<?php

namespace App\Controller\Api;

use App\Application\Services\Calendar\Connector\Connector;
use App\Application\Services\Calendar\Fetch\Fetch;
use App\Entity\ApiResponse;
use App\Entity\User;
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
class HealthController extends AbstractApiController
{
    /**
     * @Route("/hello", methods={"GET"}, name="hello")
     * @SWG\Response(
     *     response=200,
     *     description="Returns world",
     *     @SWG\Schema(
     *         type="string"
     *     )
     * )
     * @SWG\Tag(name="health")
     * @Security(name="Bearer")
     * @Areas({"internal","default"})
     */
    public function hello(): JsonResponse
    {
        $response = 'world';
        $defaultApiContext = ['groups' => 'default_api_response_group'];
        return $this->json((new ApiResponse)->setData($response), Response::HTTP_OK, [], $defaultApiContext);
    }
}