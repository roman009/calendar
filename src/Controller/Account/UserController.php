<?php

namespace App\Controller\Account;

use App\Entity\AccountUser;
use App\Entity\Service;
use App\Entity\User;
use App\Repository\AccountRepository;
use App\Repository\AccountUserRepository;
use App\Repository\Calendar\Apple\AppleAuthTokenRepository;
use App\Repository\Calendar\Exchange\ExchangeAuthTokenRepository;
use App\Repository\Calendar\Exchange\ExchangeCalendarRepository;
use App\Repository\Calendar\Google\GoogleAuthTokenRepository;
use App\Repository\Calendar\Google\GoogleCalendarRepository;
use App\Repository\Calendar\Office365\Office365AuthTokenRepository;
use App\Repository\Calendar\Outlook\OutlookAuthTokenRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(host="account.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
class UserController extends AbstractAccountController
{
    /**
     * @Route("/user/add", name="account-add-user")
     * @param Request $request
     * @param AccountRepository $accountRepository
     * @param UserRepository $userRepository
     * @param AccountUserRepository $accountUserRepository
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add(Request $request, AccountRepository $accountRepository, UserRepository $userRepository, AccountUserRepository $accountUserRepository): Response
    {
        $user = new User;

        $form = $this->createFormBuilder($user)
            ->add('email', EmailType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $account = $this->authenticate($request, $accountRepository);

            $userRepository->persistAndFlush($user);
            $accountUser = (new AccountUser)->setAccount($account)->setUser($user);
            $accountUserRepository->persistAndFlush($accountUser);

            return $this->redirectToRoute('account-homepage');
        }

        return $this->render('Account/add_user.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/user/delete/{objectId}", name="account-delete-user")
     * @param Request $request
     * @param string $objectId
     * @param AccountRepository $accountRepository
     * @param UserRepository $userRepository
     * @param AccountUserRepository $accountUserRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Request $request, string $objectId, AccountRepository $accountRepository, UserRepository $userRepository, AccountUserRepository $accountUserRepository): Response
    {
        $account = $this->authenticate($request, $accountRepository);
        $accountUser = $accountUserRepository->findOneBy(['account' => $account, 'objectId' => $objectId]);

        if (null === $accountUser) {
            throw new NotFoundHttpException();
        }

        $user = $accountUser->getUser();
        $accountUserRepository->delete($accountUser);

        if ($accountUserRepository->count(['user' => $user]) === 0) {
            $userRepository->delete($user);
        }

        return $this->redirectToRoute('account-homepage');
    }

    /**
     * @Route("/user/edit/{objectId}", name="account-edit-user")
     * @param Request $request
     * @param string $objectId
     * @param AccountRepository $accountRepository
     * @param UserRepository $userRepository
     * @param AccountUserRepository $accountUserRepository
     * @param AppleAuthTokenRepository $appleAuthTokenRepository
     * @param GoogleAuthTokenRepository $googleAuthTokenRepository
     * @param ExchangeAuthTokenRepository $exchangeAuthTokenRepository
     * @param Office365AuthTokenRepository $office365AuthTokenRepository
     * @param OutlookAuthTokenRepository $outlookAuthTokenRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function edit(
        Request $request,
        string $objectId,
        AccountRepository $accountRepository,
        UserRepository $userRepository,
        AccountUserRepository $accountUserRepository,
        AppleAuthTokenRepository $appleAuthTokenRepository,
        GoogleAuthTokenRepository $googleAuthTokenRepository,
        ExchangeAuthTokenRepository $exchangeAuthTokenRepository,
        Office365AuthTokenRepository $office365AuthTokenRepository,
        OutlookAuthTokenRepository $outlookAuthTokenRepository
    ): Response {
        $account = $this->authenticate($request, $accountRepository);

        $accountUser = $accountUserRepository->findOneBy(['account' => $account, 'objectId' => $objectId]);

        if (null === $accountUser) {
            throw new NotFoundHttpException();
        }

        $user = $accountUser->getUser();

        $form = $this->createFormBuilder($user)
            ->add('email', EmailType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        $userIntegrations = [];
        /** @var Service $service */
        foreach (Service::all() as $service) {
            $userIntegrations[$service->getName()] = ${$service->getCode().'AuthTokenRepository'}->findOneBy(['accountUser' => $accountUser]);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $userRepository->persistAndFlush($user);

            return $this->redirectToRoute('account-homepage');
        }

        return $this->render('Account/edit_user.html.twig', [
            'form' => $form->createView(),
            'user_integration' => $userIntegrations,
        ]);
    }
}