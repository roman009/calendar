<?php

namespace App\Repository\Calendar\Exchange;

use App\Entity\Calendar\Exchange\ExchangeFreeBusy;
use App\Repository\Calendar\AuthTokenRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ExchangeFreeBusy|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExchangeFreeBusy|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExchangeFreeBusy[]    findAll()
 * @method ExchangeFreeBusy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExchangeFreeBusyRepository extends AuthTokenRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ExchangeFreeBusy::class);
    }
}
