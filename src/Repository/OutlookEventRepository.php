<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\GoogleEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GoogleEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method GoogleEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method GoogleEvent[]    findAll()
 * @method GoogleEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoogleEventRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GoogleEvent::class);
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
