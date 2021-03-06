<?php

namespace App\Controller\Api;

use App\Exception\Api\ApiException;
use Nelmio\ApiDocBundle\Annotation\Areas;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * https://docs.cronofy.com/developers/api/push-notifications/create-channel/
 */

/**
 * @Route(host="api.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
class NotificationController extends AbstractApiController
{
    /**
     * @Route("/channels", methods={"GET"}, name="api-channel-list")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of notification channels",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=App\Entity\Notification\Channel::class, groups={"default_api_response_group"}))
     *     )
     * )
     * @SWG\Tag(name="channel")
     * @Security(name="Bearer")
     * @Areas({"internal","default"})
     *
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        throw new ApiException('@TODO');
    }

    /**
     * @Route("/channels", methods={"POST"}, name="api-channel-create")
     * @SWG\Response(
     *     response=200,
     *     description="Create new notification channel",
     *     @SWG\Schema(ref=@Model(type=App\Entity\Notification\Channel::class, groups={"default_api_response_group"}))
     * )
     * @SWG\Tag(name="channel")
     * @Security(name="Bearer")
     * @Areas({"internal","default"})
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        throw new ApiException('@TODO');
    }

    /**
     * @Route("/channels/{objectId}", methods={"DELETE"}, name="api-channel-delete")
     * @SWG\Response(
     *     response=200,
     *     description="Delete notification channel"
     * )
     * @SWG\Tag(name="channel")
     * @Security(name="Bearer")
     * @Areas({"internal","default"})
     *
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        throw new ApiException('@TODO');
    }
}
