<?php

namespace App\Controller\Integration;

use App\Entity\Calendar\CalendarServiceProvider;
use App\Repository\AccountRepository;
use App\Repository\AccountUserRepository;
use App\Service\Calendar\Connector\Connector;
use App\Service\Calendar\Connector\Response\RegisterOAuthAuthUrlResponse;
use App\Service\Calendar\Connector\Response\RegisterSuccessResponse;
use App\Service\Calendar\Connector\Response\RegisterUserPasswordRequestResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function connectCalendar(Request $request, string $providerName, string $objectId, AccountUserRepository $accountUserRepository, Connector $connector): Response
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

        if ($response instanceof RegisterOAuthAuthUrlResponse) {
            $session = $request->getSession();
            $session->set('accountUserObjectId', $accountUser->getObjectId());
            $session->set('providerName', $providerName);

            return $this->redirect($response->getAuthUrl());
        }

        if ($response instanceof RegisterUserPasswordRequestResponse) {
            return $this->redirectToRoute('integration-calendar-authenticate', ['providerName' => $providerName, 'objectId' => $objectId]);
        }

        throw new \RuntimeException('Unhandled integration method');
    }

    /**
     * @Route("/calendar/callback/oauth/{providerName}", name="integration-calendar-connect-oauth-callback-handler")
     * @param Request $request
     * @param string $providerName
     * @param AccountUserRepository $accountUserRepository
     * @param Connector $connector
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Exception
     */
    public function callbackOauthConnectCalendarHandler(Request $request, string $providerName, AccountUserRepository $accountUserRepository, Connector $connector): Response
    {
        $service = CalendarServiceProvider::get($providerName);

        $session = $request->getSession();
        $objectId = $session->get('accountUserObjectId');
        $providerName = $session->get('providerName');

        $service = CalendarServiceProvider::get($providerName);

        if (null === $objectId) {
            throw new \RuntimeException('Invalid session');
        }

        $accountUser = $accountUserRepository->findOneBy(['objectId' => $objectId]);
        if (null === $accountUser) {
            throw new NotFoundHttpException();
        }

        if ($connector->isRegistered($accountUser, $service)) {
            die('already connected');
        }

        $response = $connector->fetchAccessToken($request, $accountUser, $service);

        if (!$response instanceof RegisterSuccessResponse) {
            return $this->json('error', Response::HTTP_BAD_REQUEST);
        }

        return $this->json('success');
    }

    /**
     * @Route("/calendar/authenticate/{providerName}/{objectId}", name="integration-calendar-authenticate")
     * @param Request $request
     * @param string $providerName
     * @param string $objectId
     * @param AccountUserRepository $accountUserRepository
     * @param Connector $connector
     * @return \Symfony\Component\HttpFoundation\JsonResponse|Response
     * @throws \Exception
     */
    public function usernamePasswordAuthentication(Request $request, string $providerName, string $objectId, AccountUserRepository $accountUserRepository, Connector $connector): Response
    {
        $service = CalendarServiceProvider::get($providerName);

        $accountUser = $accountUserRepository->findOneBy(['objectId' => $objectId]);
        if (null === $accountUser) {
            throw new NotFoundHttpException();
        }

        if ($connector->isRegistered($accountUser, $service)) {
            die('already connected');
        }

        $form = $this->createFormBuilder()
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->add('Login', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());

            return $this->json('success');
        }

        return $this->render('Integration/authenticate.html.twig', [
            'form' => $form->createView(),
            'account_user' => $accountUser,
        ]);
    }
}
