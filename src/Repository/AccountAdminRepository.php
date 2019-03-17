<?php

namespace App\Repository;

use App\Entity\AccountAdmin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AccountAdmin|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccountAdmin|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccountAdmin[]    findAll()
 * @method AccountAdmin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountAdminRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AccountAdmin::class);
    }
}
