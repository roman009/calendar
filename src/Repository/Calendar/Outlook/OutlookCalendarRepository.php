<?php

namespace App\Repository\Calendar\Outlook;

use App\Entity\Calendar\Outlook\OutlookCalendar;
use App\Repository\BaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OutlookCalendar|null find($id, $lockMode = null, $lockVersion = null)
 * @method OutlookCalendar|null findOneBy(array $criteria, array $orderBy = null)
 * @method OutlookCalendar[]    findAll()
 * @method OutlookCalendar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OutlookCalendarRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OutlookCalendar::class);
    }
}
