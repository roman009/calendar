<?php

namespace App\Repository;

use App\Entity\GoogleFreeBusy;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GoogleFreeBusy|null find($id, $lockMode = null, $lockVersion = null)
 * @method GoogleFreeBusy|null findOneBy(array $criteria, array $orderBy = null)
 * @method GoogleFreeBusy[]    findAll()
 * @method GoogleFreeBusy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoogleFreeBusyRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GoogleFreeBusy::class);
    }
}
