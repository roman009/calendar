<?php

namespace App\Repository\SmartInvite;

use App\Entity\SmartInvite\Organizer;
use App\Repository\BaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Organizer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Organizer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Organizer[]    findAll()
 * @method Organizer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganizerRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Organizer::class);
    }
}
