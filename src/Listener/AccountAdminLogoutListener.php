<?php

namespace App\Listener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;

class AccountAdminLogoutListener implements LogoutHandlerInterface
{

    /**
     * @inheritdoc
     */
    public function logout(Request $request, Response $response, TokenInterface $token)
    {
        $session = $request->getSession();
        $session->clear();
    }
}