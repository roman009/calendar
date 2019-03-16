<?php

namespace App\Controller\Integration;

use App\Entity\Calendar\CalendarServiceProvider;
use App\Repository\AccountRepository;
use App\Repository\AccountUserRepository;
use App\Service\Calendar\Connector\Connector;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(host="integration.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
class MainController extends AbstractController
{
    /**
     * @Route("/calendar/connect/{providerName}/{objectId}", name="integration-calendar-connect")
     * @param Request $request
     * @param string $providerName
     * @param string $objectId
     * @param AccountUserRepository $accountUserRepository
     * @param Connector $connector
     * @throws \Exception
     */
    public function connectCalendar(Request $request, string $providerName, string $objectId, AccountUserRepository $accountUserRepository, Connector $connector)
    {
        $service = CalendarServiceProvider::get($providerName);

        $accountUser = $accountUserRepository->findOneBy(['objectId' => $objectId]);
        if (null === $accountUser) {
            throw new NotFoundHttpException();
        }

        if ($connector->isRegistered($accountUser, $service)) {
            die('already connected');
        }

        $response = $connector->register($accountUser, $service);

        dump($response); die();
    }

    /**
     * @Route("/calendar/callback/oauth/{providerName}/{objectId}", name="integration-calendar-connect-oauth-callback-handler")
     */
    public function callbackOauthConnectCalendarHandler(Request $request, string $providerName, string $objectId, AccountUserRepository $accountUserRepository, Connector $connector)
    {
        $service = CalendarServiceProvider::get($providerName);

        $accountUser = $accountUserRepository->findOneBy(['objectId' => $objectId]);
        if (null === $accountUser) {
            throw new NotFoundHttpException();
        }

        if ($connector->isRegistered($accountUser, $service)) {
            die('already connected');
        }


    }
}
