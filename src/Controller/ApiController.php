<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(host="api.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/hello", name="hello")
     */
    public function hello(): JsonResponse
    {
        return $this->json(['response' => 'world']);
    }

    /**
     * @Route("/", name="api-homepage")
     */
    public function homepage(): RedirectResponse
    {
        return $this->redirectToRoute('hello');
    }
}