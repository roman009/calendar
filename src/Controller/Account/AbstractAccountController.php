<?php

namespace App\Controller\Account;

use App\Entity\Account;
use App\Entity\AccountAdmin;
use App\Repository\AccountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(host="api.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
abstract class AbstractAccountController extends AbstractController
{
    protected function authenticate(Request $request, AccountRepository $accountRepository): Account
    {
        /** @var AccountAdmin $accountAdmin */
        $accountAdmin = $this->getUser();

        return $accountAdmin->getAccount()->first();
    }
}
