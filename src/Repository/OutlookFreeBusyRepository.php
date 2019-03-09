<?php

namespace App\Repository;

use App\Entity\OutlookFreeBusy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OutlookFreeBusy|null find($id, $lockMode = null, $lockVersion = null)
 * @method OutlookFreeBusy|null findOneBy(array $criteria, array $orderBy = null)
 * @method OutlookFreeBusy[]    findAll()
 * @method OutlookFreeBusy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OutlookFreeBusyRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OutlookFreeBusy::class);
    }
}
