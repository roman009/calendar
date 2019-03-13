<?php

namespace App\Controller\Api;

use Nelmio\ApiDocBundle\Annotation\Areas;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(host="api.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
class AvailabilityController extends AbstractApiController
{
    /**
     * https://docs.cronofy.com/developers/api/scheduling/availability/
     *
     * @Route("/availability", methods={"GET"}, name="api-availability")
     * @SWG\Tag(name="availability")
     * @Security(name="Bearer")
     * @Areas({"internal","default"})
     *
     * @return JsonResponse
     */
    public function availability(Request $request): JsonResponse
    {
    }
}
