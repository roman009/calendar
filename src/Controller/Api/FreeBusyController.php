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
class FreeBusyController extends AbstractApiController
{
    /**
     * @Route("/free-busy", methods={"GET"}, name="api-freebusy")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the free/busy information from the calendars",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=App\Entity\Calendar\FreeBusy::class, groups={"default_api_response_group"}))
     *     )
     * )
     * @SWG\Parameter(
     *     name="start_date",
     *     in="query",
     *     type="string",
     *     description="Start datetime of the free-busy interval"
     * )
     * @SWG\Parameter(
     *     name="end_date",
     *     in="query",
     *     type="string",
     *     description="End datetime of the free-busy interval"
     * )
     * @SWG\Parameter(
     *     name="service",
     *     in="query",
     *     type="string",
     *     description="Service to query: google, outlook, office365, apple"
     * )
     * @SWG\Parameter(
     *     name="timezone",
     *     in="query",
     *     type="string",
     *     description="Timezone of the request"
     * )
     * @SWG\Tag(name="free-busy")
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
    public function freeBusy(Request $request, Connector $connector, Fetch $fetch): JsonResponse
    {
        $user = $this->authenticate($request);

        $service = CalendarServiceProvider::get($request->get('service'));
        $startDate = new \DateTime($request->get('start_date'));
        $endDate = new \DateTime($request->get('end_date'));

        $token = $connector->getToken($user, $service);

//        $calendars = $fetch->calendars($service, $token);

        try {
//            $response = $fetch->freeBusy($service, $token, $startDate, $endDate, $calendars, $request->get('timezone'));
            $response = $fetch->freeBusy($service, $token, $startDate, $endDate, [], $request->get('timezone'));
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }

        $defaultApiContext = ['groups' => 'default_api_response_group'];
        return $this->json((new ApiResponse)->setData($response), Response::HTTP_OK, [], $defaultApiContext);
    }
}
