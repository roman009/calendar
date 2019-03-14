<?php

namespace App\Controller\Api;

use App\Entity\SmartInvite\SmartInvite;
use App\Application\Services\Calendar\Connector\Connector;
use App\Application\Services\Calendar\Fetch\Fetch;
use App\Entity\AccountUser;
use App\Entity\ApiResponse;
use App\Entity\Calendar;
use App\Entity\Service;
use App\Exception\Api\ApiException;
use Nelmio\ApiDocBundle\Annotation\Areas;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SmartInviteController
{
    /**
     * https://docs.cronofy.com/developers/api/smart-invites/create-smart-invite/
     *
     * @Route("/smart-invite", methods={"GET"}, name="api-smartinvite-list")
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of smart invites",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=App\Entity\SmartInvite::class, groups={"default_api_response_group"}))
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
    }

    /**
     * https://docs.cronofy.com/developers/api/smart-invites/create-smart-invite/
     *
     * @Route("/smart-invite", methods={"POST"}, name="api-smartinvite-create")
     * @SWG\Response(
     *     response=200,
     *     description="Create a new smart invite",
     *     @SWG\Schema(ref=@Model(type=App\Entity\SmartInvite::class, groups={"default_api_response_group"}))
     * )
     * @SWG\Parameter(
     *     name="smart-invite",
     *     in="body",
     *     type="string",
     *     schema=@SWG\Schema(ref=@Model(type=App\Entity\SmartInvite::class, groups={"default_api_write_group"})),
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

    }

    /**
     * https://docs.cronofy.com/developers/api/smart-invites/create-smart-invite/
     *
     * @Route("/smart-invite/{objectId}", methods={"DELETE"}, name="api-smartinvite-delete")
     *
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
    }
}
