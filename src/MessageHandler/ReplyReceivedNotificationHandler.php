<?php

namespace App\MessageHandler;

use App\Entity\ApiResponse;
use App\Message\ReplyReceivedNotification;
use App\Repository\SmartInvite\SmartInviteRecipientRepository;
use App\Repository\SmartInvite\SmartInviteReplyRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ReplyReceivedNotificationHandler implements MessageHandlerInterface
{
    /**
     * @var SmartInviteReplyRepository
     */
    private $smartInviteReplyRepository;
    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var Client
     */
    private $client;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var SmartInviteRecipientRepository
     */
    private $smartInviteRecipientRepository;

    public function __construct(
        SerializerInterface $serializer,
        Client $client,
        SmartInviteReplyRepository $smartInviteReplyRepository,
        SmartInviteRecipientRepository $smartInviteRecipientRepository,
        LoggerInterface $logger
    ) {
        $this->smartInviteReplyRepository = $smartInviteReplyRepository;
        $this->serializer = $serializer;
        $this->client = $client;
        $this->logger = $logger;
        $this->smartInviteRecipientRepository = $smartInviteRecipientRepository;
    }

    public function __invoke(ReplyReceivedNotification $message)
    {
        $smartInviteReply = $this->smartInviteReplyRepository->find($message->getSmartReplyId());
        $smartInvite = $smartInviteReply->getSmartInvite();

        if (empty($smartInvite->getCallbackUrl())) {
            return;
        }

        $recipient = $smartInvite->getRecipient();
        if ($smartInviteReply->getStatus() === $recipient->getStatus()) {
            return;
        }

        $recipient->setStatus($smartInviteReply->getStatus());
        $this->smartInviteReplyRepository->persistAndFlush($recipient);

        $response = (new ApiResponse)->setData($smartInvite);

        $defaultApiContext = [
            'groups' => 'default_callback_response_group',
            'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS
        ];
        $json = $this->serializer->serialize($response, 'json', $defaultApiContext);

        $headers = [
            'content-type' => 'application/json',
        ];
        $request = new Request('POST', $smartInvite->getCallbackUrl(), $headers, $json);

        $this->logger->info('POSTing to callback URL', [
            'callback_url' => $smartInvite->getCallbackUrl(),
            'json' => json_decode($json, true),
        ]);

        try {
            $this->client->send($request);
        } catch (RequestException $requestException) {
            $this->logger->error($requestException->getMessage(), [ 'domain' => get_class($this)]);
        }
    }
}
