<?php

namespace App\Repository\Calendar\Office365;

use App\Entity\Calendar\Office365\Office365FreeBusy;
use App\Repository\BaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Office365FreeBusy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Office365FreeBusy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Office365FreeBusy[]    findAll()
 * @method Office365FreeBusy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Office365FreeBusyRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Office365FreeBusy::class);
    }
}
