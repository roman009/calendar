<?php

namespace App\Controller;

use App\Application\Services\Calendar\Connector\Connector;
use App\Application\Services\Calendar\Fetch\Fetch;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(host="api.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/hello", name="hello")
     */
    public function hello(): JsonResponse
    {
        return $this->json(['response' => 'world']);
    }

    /**
     * @Route("/", name="api-homepage")
     */
    public function homepage(): RedirectResponse
    {
        return $this->redirectToRoute('hello');
    }

    /**
     * @Route("/free-busy", methods={"GET"}, name="api-freebusy")
     * @param Request $request
     * @param Connector $connector
     * @param Fetch $fetch
     * @return JsonResponse
     */
    public function freeBusy(Request $request, Connector $connector, Fetch $fetch)
    {
        $user = $this->authenticate($request);

        $service = $request->get('service');
        $startDate = new \DateTime($request->get('start_date'));
        $endDate = new \DateTime($request->get('end_date'));

        $token = $connector->getToken($user, $service);

        $calendars = $fetch->calendars($service, $token);

        $response = $fetch->freeBusy($service, $token, $startDate, $endDate, $calendars, $request->get('timezone'));

        $defaultApiContext = ['groups' => 'default_api_response_group'];
        return $this->json($response, Response::HTTP_OK, [], $defaultApiContext);
    }

    private function authenticate(Request $request)
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => 'valeriu.buzila@gmail.com']);

        return $user;
    }
}
