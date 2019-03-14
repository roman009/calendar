<?php

namespace App\Repository\SmartInvite;

use App\Entity\SmartInvite\SmartInvite;
use App\Repository\BaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SmartInvite|null find($id, $lockMode = null, $lockVersion = null)
 * @method SmartInvite|null findOneBy(array $criteria, array $orderBy = null)
 * @method SmartInvite[]    findAll()
 * @method SmartInvite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SmartInviteRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SmartInvite::class);
    }
}
