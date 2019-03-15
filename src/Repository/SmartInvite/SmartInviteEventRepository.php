<?php

namespace App\Repository\SmartInvite;

use App\Entity\SmartInvite\SmartInviteEvent;
use App\Repository\BaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SmartInviteEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method SmartInviteEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method SmartInviteEvent[]    findAll()
 * @method SmartInviteEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SmartInviteEventRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SmartInviteEvent::class);
    }
}
