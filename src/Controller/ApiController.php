<?php

namespace App\Controller;

use App\Application\Services\Calendar\Connector\Connector;
use App\Application\Services\Calendar\Fetch\Fetch;
use App\Entity\ApiResponse;
use App\Entity\User;
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
class ApiController extends AbstractController
{
    /**
     * @Route("/hello", methods={"GET"}, name="hello")
     * @SWG\Response(
     *     response=200,
     *     description="Returns world",
     *     @SWG\Schema(
     *         type="string"
     *     )
     * )
     * @SWG\Tag(name="default")
     * @Security(name="Bearer")
     * @Areas({"internal","default"})
     */
    public function hello(): JsonResponse
    {
        $response = 'world';
        $defaultApiContext = ['groups' => 'default_api_response_group'];
        return $this->json((new ApiResponse)->setData($response), Response::HTTP_OK, [], $defaultApiContext);
    }

    /**
     * @Route("/free-busy", methods={"GET"}, name="api-freebusy")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the free/busy information from the calendars",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=App\Entity\FreeBusy::class, groups={"default_api_response_group"}))
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

        $service = $request->get('service');
        $startDate = new \DateTime($request->get('start_date'));
        $endDate = new \DateTime($request->get('end_date'));

        $token = $connector->getToken($user, $service);

        $calendars = $fetch->calendars($service, $token);

        try {
            $response = $fetch->freeBusy($service, $token, $startDate, $endDate, $calendars, $request->get('timezone'));
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }

        $defaultApiContext = ['groups' => 'default_api_response_group'];
        return $this->json((new ApiResponse)->setData($response), Response::HTTP_OK, [], $defaultApiContext);
    }

    /**
     * @Route("/calendar", methods={"GET"}, name="api-calendar")
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
    public function calendar(Request $request, Connector $connector, Fetch $fetch): JsonResponse
    {
        $user = $this->authenticate($request);

        $service = $request->get('service');

        $token = $connector->getToken($user, $service);

        try {
            $calendars = $fetch->calendars($service, $token);
        } catch (\Exception $e) {
            throw new ApiException($e->getMessage());
        }

        $defaultApiContext = ['groups' => 'default_api_response_group'];
        return $this->json((new ApiResponse)->setData($calendars), Response::HTTP_OK, [], $defaultApiContext);
    }

    private function authenticate(Request $request)
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => 'valeriu.buzila@gmail.com']);

        return $user;
    }
}
