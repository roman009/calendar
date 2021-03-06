<?php

namespace App\Repository\Calendar\Google;

use App\Entity\Calendar\Google\ExchangeFreeBusy;
use App\Repository\BaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ExchangeFreeBusy|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExchangeFreeBusy|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExchangeFreeBusy[]    findAll()
 * @method ExchangeFreeBusy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoogleFreeBusyRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ExchangeFreeBusy::class);
    }
}
