<?php

namespace App\Repository;

use App\Entity\ExchangeCalendar;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ExchangeCalendar|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExchangeCalendar|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExchangeCalendar[]    findAll()
 * @method ExchangeCalendar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExchangeCalendarRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ExchangeCalendar::class);
    }
}
