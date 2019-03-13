<?php

namespace App\EventListener;

use App\Entity\ApiResponse;
use App\Exception\Api\ApiException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Serializer\SerializerInterface;

class ApiExceptionListener
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$exception instanceof ApiException) {
            return;
        }

        $response = (new ApiResponse)->addError(['message' => $exception->getMessage(), 'code' => $exception->getCode()]);

        $defaultApiContext = [
            'groups' => 'default_api_response_group',
            'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS
        ];
        $json = $this->serializer->serialize($response, 'json', $defaultApiContext);

        $response = new JsonResponse($json, Response::HTTP_BAD_REQUEST, [], true);

        $event->setResponse($response);
    }
}
