<?php

namespace App\Repository\Calendar\Outlook;

use App\Entity\Calendar\Outlook\Office365FreeBusy;
use App\Repository\BaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Office365FreeBusy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Office365FreeBusy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Office365FreeBusy[]    findAll()
 * @method Office365FreeBusy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OutlookFreeBusyRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Office365FreeBusy::class);
    }
}
