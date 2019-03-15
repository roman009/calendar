<?php

namespace App\Controller\Api;

use Nelmio\ApiDocBundle\Annotation\Areas;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
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
     * @Route("/resource", methods={"GET"}, name="api-resource-list")
     *
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
    }
}
