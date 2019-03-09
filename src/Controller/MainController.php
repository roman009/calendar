<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route(
     *     "/",
     *     name="homepage",
     *     host="{domain}",
     *     defaults={"domain" = "%domain%"},
     *     requirements={"domain" = "%domain%"}
     * )
     */
    public function homepage(): JsonResponse
    {
        return $this->json(['this is the homepage']);
    }
}