<?php

namespace App\Controller\Api;

use App\Entity\ApiResponse;
use App\Entity\Calendar\CalendarServiceProvider;
use App\Exception\Api\ApiException;
use App\Service\Calendar\Connector\Connector;
use App\Service\Calendar\Fetch\Fetch;
use Nelmio\ApiDocBundle\Annotation\Areas;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * https://docs.cronofy.com/developers/api/events/read-events/
 */

/**
 * @Route(host="api.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
class EventController extends AbstractApiController
{
    /**
     * @Route("/events", methods={"GET"}, name="api-event-list")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of events",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=App\Entity\Calendar\Event::class, groups={"default_api_response_group"}))
     *     )
     * )
     * @SWG\Tag(name="event")
     * @Security(name="Bearer")
     * @Areas({"internal","default"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function list(Request $request): JsonResponse
    {
        throw new ApiException('@TODO');
    }

    /**
     * @Route("/events", methods={"POST"}, name="api-event-create")
     * @SWG\Response(
     *     response=200,
     *     description="Create a new event in the selected service",
     *     @SWG\Schema(ref=@Model(type=App\Entity\Calendar\Event::class, groups={"default_api_response_group"}))
     * )
     * @SWG\Tag(name="event")
     * @Security(name="Bearer")
     * @Areas({"internal","default"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function create(Request $request): JsonResponse
    {
        throw new ApiException('@TODO');
    }

    /**
     * @Route("/events/{objectId}", methods={"PATCH"}, name="api-event-update")
     * @SWG\Response(
     *     response=200,
     *     description="Update an event in the selected service",
     *     @SWG\Schema(ref=@Model(type=App\Entity\Calendar\Event::class, groups={"default_api_response_group"}))
     * )
     * @SWG\Tag(name="event")
     * @Security(name="Bearer")
     * @Areas({"internal","default"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function update(Request $request): JsonResponse
    {
        throw new ApiException('@TODO');
    }

    /**
     * @Route("/events/{objectId}", methods={"DELETE"}, name="api-event-delete")
     * @SWG\Response(
     *     response=200,
     *     description="Delete an event in the selected service"
     * )
     * @SWG\Tag(name="event")
     * @Security(name="Bearer")
     * @Areas({"internal","default"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function delete(Request $request): JsonResponse
    {
        throw new ApiException('@TODO');
    }
}
