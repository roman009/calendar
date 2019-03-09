<?php

namespace App\Repository;

use App\Entity\GoogleAuthToken;
use App\Entity\OutlookAuthToken;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GoogleAuthToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method GoogleAuthToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method GoogleAuthToken[]    findAll()
 * @method GoogleAuthToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OutlookAuthTokenRepository extends AuthTokenRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OutlookAuthToken::class);
    }

    // /**
    //  * @return GoogleToken[] Returns an array of GoogleToken objects
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
    public function findOneBySomeField($value): ?GoogleToken
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
