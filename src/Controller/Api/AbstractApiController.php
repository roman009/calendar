<?php

namespace App\Controller\Api;

use App\Entity\AccountUser;
use App\Repository\AccountUserRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(host="api.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
abstract class AbstractApiController extends AbstractController
{
    protected function authenticate(Request $request, UserRepository $userRepository, AccountUserRepository $accountUserRepository): AccountUser
    {
        $user = $userRepository->findOneBy(['email' => 'valeriu.buzila@gmail.com']);

        return $accountUserRepository->findOneBy(['user' => $user]);
    }
}
