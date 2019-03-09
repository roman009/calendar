<?php

namespace App\Repository;

use App\Entity\AccountUser;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AccountUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccountUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccountUser[]    findAll()
 * @method AccountUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountUserRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AccountUser::class);
    }

    // /**
    //  * @return AccountUser[] Returns an array of AccountUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AccountUser
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
