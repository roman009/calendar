<?php

namespace App\Controller\Api;

use App\Entity\SmartInvite\SmartInvite;
use App\Exception\Api\ApiException;
use Nelmio\ApiDocBundle\Annotation\Areas;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * https://docs.cronofy.com/developers/api/smart-invites/create-smart-invite/
 */

/**
 * @Route(host="api.{domain}", defaults={"domain" = "%domain%"}, requirements={"domain" = "%domain%"})
 */
class SmartInviteController extends AbstractApiController
{
    /**
     * @Route("/smart-invites", methods={"GET"}, name="api-smartinvite-list")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of smart invites",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=App\Entity\SmartInvite\SmartInvite::class, groups={"default_api_response_group"}))
     *     )
     * )
     * @SWG\Tag(name="smart-invite")
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
     * @Route("/smart-invites", methods={"POST"}, name="api-smartinvite-create")
     * @SWG\Response(
     *     response=200,
     *     description="Create a new smart invite",
     *     @SWG\Schema(ref=@Model(type=App\Entity\SmartInvite\SmartInvite::class, groups={"default_api_response_group"}))
     * )
     * @SWG\Parameter(
     *     name="smart-invite",
     *     in="body",
     *     type="string",
     *     schema=@SWG\Schema(ref=@Model(type=App\Entity\SmartInvite\SmartInvite::class, groups={"default_api_write_group"})),
     *     description="Smart invite body"
     * )
     * @SWG\Tag(name="smart-invite")
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
     * @Route("/smart-invites/{objectId}", methods={"DELETE"}, name="api-smartinvite-delete")
     * @SWG\Response(
     *     response=200,
     *     description="Delete smart invite"
     * )
     * @SWG\Parameter(
     *     name="objectId",
     *     in="query",
     *     type="string",
     *     description="Smart-invite ID"
     * )
     * @SWG\Tag(name="smart-invite")
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
