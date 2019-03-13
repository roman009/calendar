<?php

namespace App\Controller\Api;

use App\Entity\AccountUser;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(host="api.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
abstract class AbstractApiController extends AbstractController
{
    protected function authenticate(Request $request): AccountUser
    {
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => 'valeriu.buzila@gmail.com']);

        $accountUserRepository = $this->getDoctrine()->getRepository(AccountUser::class);
        $accountUser = $accountUserRepository->findOneBy(['user' => $user]);

        return $accountUser;
    }
}
