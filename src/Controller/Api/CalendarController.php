<?php

namespace App\Controller\Api;

use App\Application\Services\Calendar\Connector\Connector;
use App\Application\Services\Calendar\Fetch\Fetch;
use App\Entity\ApiResponse;
use App\Entity\Calendar;
use App\Exception\Api\ApiException;
use Nelmio\ApiDocBundle\Annotation\Areas;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(host="api.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
class CalendarController extends AbstractApiController
{

    /**
     * @Route("/calendar", methods={"GET"}, name="api-calendar-list")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of connected calendars",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=App\Entity\Calendar::class, groups={"default_api_response_group"}))
     *     )
     * )
     * @SWG\Parameter(
     *     name="service",
     *     in="query",
     *     type="string",
     *     description="Service to query: google, outlook, office365, apple"
     * )
     * @SWG\Tag(name="calendar")
     * @Security(name="Bearer")
     * @Areas({"internal","default"})
     *
     * @param Request $request
     * @param Connector $connector
     * @param Fetch $fetch
     *
     * @throws \Exception
     *
     * @return JsonResponse
     */
    public function list(Request $request, Connector $connector, Fetch $fetch): JsonResponse
    {
        $accountUser = $this->authenticate($request);

        $service = $request->get('service');

        $token = $connector->getToken($accountUser, $service);

        try {
            $response = $fetch->calendars($service, $token);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }

        $defaultApiContext = ['groups' => 'default_api_response_group'];
        return $this->json((new ApiResponse)->setData($response), Response::HTTP_OK, [], $defaultApiContext);
    }

    /**
     * @Route("/calendar/{objectId}/events", methods={"GET"}, name="api-calendar-events")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of events in specific calendar",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=App\Entity\Event::class, groups={"default_api_response_group"}))
     *     )
     * )
     * @SWG\Parameter(
     *     name="start_date",
     *     in="query",
     *     type="string",
     *     description="Start datetime of the events interval"
     * )
     * @SWG\Parameter(
     *     name="end_date",
     *     in="query",
     *     type="string",
     *     description="End datetime of the events interval"
     * )
     * @SWG\Parameter(
     *     name="service",
     *     in="query",
     *     type="string",
     *     description="Service to query: google, outlook, office365, apple"
     * )
     * @SWG\Parameter(
     *     name="objectId",
     *     in="query",
     *     type="string",
     *     description="Calendar ID"
     * )
     * @SWG\Tag(name="calendar")
     * @Security(name="Bearer")
     * @Areas({"internal","default"})
     *
     * @param Request $request
     * @param Connector $connector
     * @param Fetch $fetch
     *
     * @throws \Exception
     *
     * @return JsonResponse
     */
    public function calendarEvents(Request $request, Connector $connector, Fetch $fetch): JsonResponse
    {
        $accountUser = $this->authenticate($request);

        $service = $request->get('service');
        $calendarId = $request->get('objectId');
        $startDate = new \DateTime($request->get('start_date'));
        $endDate = new \DateTime($request->get('end_date'));
        $timezone = $request->get('timezone');

        $token = $connector->getToken($accountUser, $service);

        try {
            $response = $fetch->events($service, $token, $startDate, $endDate, $calendarId, $timezone);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }

        $defaultApiContext = ['groups' => 'default_api_response_group'];
        return $this->json((new ApiResponse)->setData($response), Response::HTTP_OK, [], $defaultApiContext);
    }

    /**
     * @Route("/calendar", methods={"POST"}, name="api-calendar-create")
     * @SWG\Response(
     *     response=200,
     *     description="Create a new calendar in the selected service",
     *     @SWG\Schema(ref=@Model(type=App\Entity\Calendar::class, groups={"default_api_response_group"}))
     * )
     * @SWG\Parameter(
     *     name="service",
     *     in="query",
     *     type="string",
     *     description="Service to query: google, outlook, office365, apple"
     * )
     * @SWG\Parameter(
     *     name="name",
     *     in="body",
     *     type="string",
     *     schema=@SWG\Schema(ref=@Model(type=App\Entity\Calendar::class, groups={"default_api_write_group"})),
     *     description="Calendar name"
     * )
     * @SWG\Tag(name="calendar")
     * @Security(name="Bearer")
     * @Areas({"internal","default"})
     *
     * @param Request $request
     * @param Connector $connector
     * @param Fetch $fetch
     *
     * @throws \Exception
     *
     * @return JsonResponse
     */
    public function create(Request $request, Connector $connector, Fetch $fetch): JsonResponse
    {

    }
}