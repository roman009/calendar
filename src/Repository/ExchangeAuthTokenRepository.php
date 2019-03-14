<?php

namespace App\Repository;

use App\Entity\ExchangeAuthToken;
use App\Entity\GoogleAuthToken;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ExchangeAuthToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExchangeAuthToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExchangeAuthToken[]    findAll()
 * @method ExchangeAuthToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExchangeAuthTokenRepository extends AuthTokenRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ExchangeAuthToken::class);
    }
}
