<?php

namespace App\Repository;

use App\Entity\AppleAuthToken;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AppleAuthToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppleAuthToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method AppleAuthToken[]    findAll()
 * @method AppleAuthToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppleAuthTokenRepository extends AuthTokenRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AppleAuthToken::class);
    }
}
