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
class NotificationController extends AbstractApiController
{

    /**
     * https://docs.cronofy.com/developers/api/push-notifications/create-channel/
     *
     * @Route("/channel", methods={"GET"}, name="api-channel-list")
     * @SWG\Tag(name="channel")
     * @Security(name="Bearer")
     * @Areas({"internal","default"})
     *
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {

    }

    /**
     * https://docs.cronofy.com/developers/api/push-notifications/create-channel/
     *
     * @Route("/channel", methods={"POST"}, name="api-channel-create")
     * @SWG\Tag(name="channel")
     * @Security(name="Bearer")
     * @Areas({"internal","default"})
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {

    }

    /**
     * https://docs.cronofy.com/developers/api/push-notifications/create-channel/
     *
     * @Route("/channel/{objectId}", methods={"DELETE"}, name="api-channel-delete")
     * @SWG\Tag(name="channel")
     * @Security(name="Bearer")
     * @Areas({"internal","default"})
     *
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {

    }
}