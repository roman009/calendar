<?php

namespace App\Repository\Calendar\Office365;

use App\Entity\Calendar\Office365\Office365AuthToken;
use App\Repository\Calendar\AuthTokenRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Office365AuthToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method Office365AuthToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method Office365AuthToken[]    findAll()
 * @method Office365AuthToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Office365AuthTokenRepository extends AuthTokenRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Office365AuthToken::class);
    }
}
