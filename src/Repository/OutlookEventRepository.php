<?php

namespace App\Repository;

use App\Entity\OutlookEvent;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OutlookEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method OutlookEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method OutlookEvent[]    findAll()
 * @method OutlookEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OutlookEventRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OutlookEvent::class);
    }
}
