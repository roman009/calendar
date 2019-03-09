<?php

namespace App\Repository;

use App\Entity\GoogleCalendar;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GoogleCalendar|null find($id, $lockMode = null, $lockVersion = null)
 * @method GoogleCalendar|null findOneBy(array $criteria, array $orderBy = null)
 * @method GoogleCalendar[]    findAll()
 * @method GoogleCalendar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoogleCalendarRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GoogleCalendar::class);
    }
}
