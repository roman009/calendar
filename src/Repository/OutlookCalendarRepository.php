<?php

namespace App\Repository;

use App\Entity\GoogleCalendar;
use App\Entity\OutlookCalendar;
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
