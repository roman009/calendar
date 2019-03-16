<?php

namespace App\Controller\Account;

use App\Repository\AccountRepository;
use App\Repository\AccountUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(host="account.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
class MainController extends AbstractAccountController
{
    /**
     * @Route("/", name="account-homepage")
     */
    public function homepage(Request $request, AccountRepository $accountRepository, AccountUserRepository $accountUserRepository): Response
    {
        $account = $this->authenticate($request, $accountRepository);

        $accountUsers = $account->getAccountUsers();

        return $this->render('Account/homepage.html.twig', ['account_users' => $accountUsers]);
    }
}
