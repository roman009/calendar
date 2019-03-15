<?php

namespace App\Entity\Notification;

use App\Entity\BaseAccountUserEntityTrait;
use App\Entity\BaseEntityTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SmartInvite\SmartInviteRepository")
 * @ORM\Table(indexes={@ORM\Index(columns={"account_user_id", "object_id"})})
 * @ORM\HasLifecycleCallbacks
 */
class Channel
{
    use BaseEntityTrait;
    use BaseAccountUserEntityTrait;
}
