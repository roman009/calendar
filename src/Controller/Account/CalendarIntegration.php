<?php

namespace App\Controller\Account;

use App\Entity\Calendar\CalendarServiceProvider;
use App\Entity\User;
use App\Repository\AccountRepository;
use App\Repository\AccountUserRepository;
use App\Service\Account\CalendarServiceProviderIntegrations;
use App\Service\Calendar\Connector\Connector;
use App\Service\Calendar\Fetch\Fetch;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(host="account.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
class CalendarIntegration extends AbstractAccountController
{
    /**
     * @Route("/user/edit/{objectId}/calendar/delete/{providerName}/{tokenObjectId}", name="account-delete-calendar-integration")
     *
     * @param Request $request
     * @param string $providerName
     * @param string $objectId
     * @param string $tokenObjectId
     * @param AccountRepository $accountRepository
     * @param AccountUserRepository $accountUserRepository
     * @param CalendarServiceProviderIntegrations $calendarServiceProviderIntegrations
     *
     * @throws \Exception
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteCalendarIntegration(
        Request $request,
        string $providerName,
        string $objectId,
        string $tokenObjectId,
        AccountRepository $accountRepository,
        AccountUserRepository $accountUserRepository,
        CalendarServiceProviderIntegrations $calendarServiceProviderIntegrations
    ): Response {
        $account = $this->authenticate($request, $accountRepository);
        $accountUser = $accountUserRepository->findOneBy(['account' => $account, 'objectId' => $objectId]);

        if (null === $accountUser) {
            throw new NotFoundHttpException();
        }

        $userIntegrations = $calendarServiceProviderIntegrations->get($accountUser);
        $service = CalendarServiceProvider::get($providerName);

        foreach ($userIntegrations as $integration) {
            if ($integration['service']->getCode() === $service->getCode() && $integration['token']->getObjectId() === $tokenObjectId) {
                $this->getDoctrine()->getManager()->remove($integration['token']);
                $this->getDoctrine()->getManager()->flush();
                break;
            }
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/user/edit/{objectId}/calendar/list/{providerName}", name="account-view-calendar-integration")
     *
     * @param Request $request
     * @param string $providerName
     * @param string $objectId
     * @param AccountRepository $accountRepository
     * @param AccountUserRepository $accountUserRepository
     * @param Connector $connector
     * @param Fetch $fetch
     *
     * @throws \Exception
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function viewCalendarsInCalendarIntegration(
        Request $request,
        string $providerName,
        string $objectId,
        AccountRepository $accountRepository,
        AccountUserRepository $accountUserRepository,
        Connector $connector,
        Fetch $fetch
    ): Response {
        $account = $this->authenticate($request, $accountRepository);
        $accountUser = $accountUserRepository->findOneBy(['account' => $account, 'objectId' => $objectId]);

        if (null === $accountUser) {
            throw new NotFoundHttpException();
        }

        $service = CalendarServiceProvider::get($providerName);
        $token = $connector->getToken($accountUser, $service);
        $response = $fetch->calendars($service, $token);
        dump($response);
        die();
    }
}
