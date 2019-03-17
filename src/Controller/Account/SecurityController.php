<?php

namespace App\Controller\Account;

use App\Entity\Account;
use App\Entity\AccountAdmin;
use App\Repository\AccountAdminRepository;
use App\Repository\AccountRepository;
use App\Security\AccountAdminAuthenticator;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route(host="account.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
class SecurityController extends AbstractAccountController
{
    /**
     * @Route("/login", name="account-login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('Account/security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="account-logout")
     */
    public function logout()
    {
        throw new \Exception('Never here');
    }

    /**
     * @Route("/register", name="account-register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, AccountAdminRepository $accountAdminRepository, AccountRepository $accountRepository, GuardAuthenticatorHandler $guardAuthenticatorHandler, AccountAdminAuthenticator $accountAdminAuthenticator): Response
    {
        $accountAdmin = new AccountAdmin;

        $form = $this->createFormBuilder($accountAdmin)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accountAdmin->setPassword(
                $passwordEncoder->encodePassword($accountAdmin, $accountAdmin->getPassword())
            );

            $accountAdminRepository->persistAndFlush($accountAdmin);

            $account = (new Account)
                ->setName('some test name ' . rand(0, 100000000) . ' ' . $accountAdmin->getEmail());

            $accountRepository->persistAndFlush($account);

            $account->addAccountAdmin($accountAdmin);
            $accountAdmin->addAccount($account);
            $accountAdminRepository->persistAndFlush($accountAdmin);
            $accountRepository->persistAndFlush($account);

            return $guardAuthenticatorHandler->authenticateUserAndHandleSuccess(
                $accountAdmin,
                $request,
                $accountAdminAuthenticator,
                'secured_account_area'
            );
        }

        $error = $form->getErrors()->current();

        return $this->render('Account/security/register.html.twig', [
            'last_username' => $form->get('email')->getData(),
            'error' => $error,
            'form' => $form->createView(),
        ]);
    }
}
