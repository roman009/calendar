<?php

namespace App\Repository;

use App\Entity\GoogleEvent;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GoogleEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method GoogleEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method GoogleEvent[]    findAll()
 * @method GoogleEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoogleEventRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GoogleEvent::class);
    }
}
