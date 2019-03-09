<?php

namespace App\EventListener;

use App\Entity\ApiResponse;
use App\Exception\Api\ApiException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ApiExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if (!$exception instanceof ApiException) {
            return;
        }

//        $response = (new ApiResponse)->setErrors(['message' => $exception->getMessage()]);
        $response = new JsonResponse($response, Response::HTTP_BAD_REQUEST);

        $event->setResponse($response);
    }
}