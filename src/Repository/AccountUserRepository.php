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
}
