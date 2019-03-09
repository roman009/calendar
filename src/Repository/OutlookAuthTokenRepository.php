<?php

namespace App\Repository;

use App\Entity\GoogleAuthToken;
use App\Entity\OutlookAuthToken;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OutlookAuthToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method OutlookAuthToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method OutlookAuthToken[]    findAll()
 * @method OutlookAuthToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OutlookAuthTokenRepository extends AuthTokenRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OutlookAuthToken::class);
    }
}
