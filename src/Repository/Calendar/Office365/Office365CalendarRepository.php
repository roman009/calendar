<?php

namespace App\Repository\Calendar\Office365;

use App\Entity\Calendar\Office365\Office365Calendar;
use App\Repository\BaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Office365Calendar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Office365Calendar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Office365Calendar[]    findAll()
 * @method Office365Calendar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Office365CalendarRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Office365Calendar::class);
    }
}
