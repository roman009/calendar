<?php

namespace App\Controller\Api;

use App\Application\Services\Calendar\Connector\Connector;
use App\Application\Services\Calendar\Fetch\Fetch;
use App\Entity\ApiResponse;
use App\Entity\Calendar;
use App\Exception\Api\ApiException;
use Nelmio\ApiDocBundle\Annotation\Areas;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(host="api.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
class AvailabilityController extends AbstractApiController
{
    /**
     * https://docs.cronofy.com/developers/api/scheduling/availability/
     *
     * @Route("/availability", methods={"GET"}, name="api-availability")
     * @SWG\Tag(name="availability")
     * @Security(name="Bearer")
     * @Areas({"internal","default"})
     *
     * @return JsonResponse
     */
    public function availability(Request $request): JsonResponse
    {

    }
}