<?php

namespace App\Repository;

use App\Entity\GoogleAuthToken;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GoogleAuthToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method GoogleAuthToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method GoogleAuthToken[]    findAll()
 * @method GoogleAuthToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoogleAuthTokenRepository extends AuthTokenRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GoogleAuthToken::class);
    }
}
