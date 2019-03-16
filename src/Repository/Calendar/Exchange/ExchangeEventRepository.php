<?php

namespace App\Repository\Calendar\Exchange;

use App\Entity\Calendar\Exchange\ExchangeEvent;
use App\Repository\Calendar\AuthTokenRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ExchangeEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExchangeEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExchangeEvent[]    findAll()
 * @method ExchangeEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExchangeEventRepository extends AuthTokenRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ExchangeEvent::class);
    }
}
