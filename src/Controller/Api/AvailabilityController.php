<?php

namespace App\Controller\Api;

use App\Exception\Api\ApiException;
use Nelmio\ApiDocBundle\Annotation\Areas;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * https://docs.cronofy.com/developers/api/scheduling/availability/
 */

/**
 * @Route(host="api.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
class AvailabilityController extends AbstractApiController
{
    /**
     * @Route("/availability", methods={"GET"}, name="api-availability")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of connected calendars",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=App\Entity\Calendar\Calendar::class, groups={"default_api_response_group"}))
     *     )
     * )
     * @SWG\Tag(name="availability")
     * @Security(name="Bearer")
     * @Areas({"internal","default"})
     *
     * @return JsonResponse
     */
    public function availability(Request $request): JsonResponse
    {
        throw new ApiException('@TODO');
    }
}
