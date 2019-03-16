<?php

namespace App\Controller\Api;

use App\Exception\Api\ApiException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * https://docs.cronofy.com/developers/api/enterprise-connect/list-resources/
 */

/**
 * @Route(host="api.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
class ResourceController extends AbstractApiController
{
    /**
     * @Route("/resources", methods={"GET"}, name="api-resource-list")
     *
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        throw new ApiException('@TODO');
    }
}
