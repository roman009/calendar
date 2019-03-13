<?php

namespace App\Entity\OAuth;

use App\Entity\AccountUser;
use App\Entity\BaseAccountUserEntityTrait;
use App\Entity\BaseEntityTrait;
use Doctrine\ORM\Mapping as ORM;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OAuth\ApiAccessTokenRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ApiAccessTokenEntity implements AccessTokenEntityInterface
{
    use AccessTokenTrait, TokenEntityTrait, EntityTrait;
    use BaseEntityTrait;
    use BaseAccountUserEntityTrait;

    /**
     * @var AccountUser
     * @ORM\OneToOne(targetEntity="App\Entity\AccountUser")
     * @ORM\JoinColumn(fieldName="account_user_id", nullable=false, referencedColumnName="id")
     */
    protected $accountUser;
}
