<?php

namespace App\MessageHandler;

use App\Entity\ApiResponse;
use App\Message\ReplyReceivedNotification;
use App\Repository\SmartInvite\SmartInviteReplyRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
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

    public function __construct(
        SerializerInterface $serializer,
        Client $client,
        SmartInviteReplyRepository $smartInviteReplyRepository
    ) {
        $this->smartInviteReplyRepository = $smartInviteReplyRepository;
        $this->serializer = $serializer;
        $this->client = $client;
    }

    public function __invoke(ReplyReceivedNotification $message)
    {
        $smartInviteReply = $this->smartInviteReplyRepository->find($message->getSmartReplyId());
        $smartInvite = $smartInviteReply->getSmartInvite();

        if (empty($smartInvite->getCallbackUrl())) {
            return;
        }

        $response = (new ApiResponse)->setData($smartInvite);

        $defaultApiContext = [
            'groups' => 'default_api_response_group',
            'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS
        ];
        $json = $this->serializer->serialize($response, 'json', $defaultApiContext);

        $headers = [
            'content-type' => 'application/json',
        ];
        $request = new Request('POST', $smartInvite->getCallbackUrl(), $headers, $json);
        $this->client->request($request);
    }
}