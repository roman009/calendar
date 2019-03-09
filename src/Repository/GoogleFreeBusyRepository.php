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

    // /**
    //  * @return GoogleFreeBusy[] Returns an array of GoogleFreeBusy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GoogleFreeBusy
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
