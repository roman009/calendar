<?php

namespace App\Repository\SmartInvite;

use App\Entity\SmartInvite\SmartInviteOrganizer;
use App\Repository\BaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SmartInviteOrganizer|null find($id, $lockMode = null, $lockVersion = null)
 * @method SmartInviteOrganizer|null findOneBy(array $criteria, array $orderBy = null)
 * @method SmartInviteOrganizer[]    findAll()
 * @method SmartInviteOrganizer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SmartInviteOrganizerRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SmartInviteOrganizer::class);
    }
}
