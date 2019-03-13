<?php

namespace App\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(host="{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
class MainController extends AbstractController
{
    /**
     * @Route("/", name="web-homepage")
     */
    public function homepage(): JsonResponse
    {
        return $this->json(['message' => 'hello world']);
    }
}
