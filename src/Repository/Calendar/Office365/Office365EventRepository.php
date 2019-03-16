<?php

namespace App\Repository\Calendar\Office365;

use App\Entity\Calendar\Office365\Office365Event;
use App\Repository\BaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Office365Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Office365Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Office365Event[]    findAll()
 * @method Office365Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Office365EventRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Office365Event::class);
    }
}
