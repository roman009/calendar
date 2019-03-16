<?php

namespace App\Controller\Account;

use App\Entity\AccountUser;
use App\Entity\User;
use App\Repository\AccountRepository;
use App\Repository\AccountUserRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(host="account.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
class UserController extends AbstractAccountController
{
    /**
     * @Route("/add-user", name="account-add-user")
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
     * @Route("/delete-user/{objectId}", name="account-delete-user")
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

        $user = $userRepository->findOneBy(['objectId' => $objectId]);
        $accountUser = $accountUserRepository->findOneBy(['account' => $account, 'user' => $user]);

        $accountUserRepository->delete($accountUser);
        $userRepository->delete($user);

        return $this->redirectToRoute('account-homepage');
    }
}