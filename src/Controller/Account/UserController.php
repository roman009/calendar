<?php

namespace App\Controller\Account;

use App\Entity\AccountUser;
use App\Entity\User;
use App\Repository\AccountRepository;
use App\Repository\AccountUserRepository;
use App\Repository\UserRepository;
use App\Service\Account\CalendarServiceProviderIntegrations;
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
     *
     * @param Request $request
     * @param AccountRepository $accountRepository
     * @param UserRepository $userRepository
     * @param AccountUserRepository $accountUserRepository
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @return Response
     */
    public function add(
        Request $request,
        AccountRepository $accountRepository,
        UserRepository $userRepository,
        AccountUserRepository $accountUserRepository
    ): Response {
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
     *
     * @param Request $request
     * @param string $objectId
     * @param AccountRepository $accountRepository
     * @param UserRepository $userRepository
     * @param AccountUserRepository $accountUserRepository
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(
        Request $request,
        string $objectId,
        AccountRepository $accountRepository,
        UserRepository $userRepository,
        AccountUserRepository $accountUserRepository
    ): Response {
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
     *
     * @param Request $request
     * @param string $objectId
     * @param AccountRepository $accountRepository
     * @param UserRepository $userRepository
     * @param AccountUserRepository $accountUserRepository
     * @param CalendarServiceProviderIntegrations $calendarServiceProviderIntegrations
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function edit(
        Request $request,
        string $objectId,
        AccountRepository $accountRepository,
        UserRepository $userRepository,
        AccountUserRepository $accountUserRepository,
        CalendarServiceProviderIntegrations $calendarServiceProviderIntegrations
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

        $userIntegrations = $calendarServiceProviderIntegrations->get($accountUser);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $userRepository->persistAndFlush($user);

            return $this->redirectToRoute('account-homepage');
        }

        return $this->render('Account/edit_user.html.twig', [
            'form' => $form->createView(),
            'user_integration' => $userIntegrations,
            'account_user' => $accountUser,
        ]);
    }
}
