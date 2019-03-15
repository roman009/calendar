<?php

namespace App\Repository\SmartInvite;

use App\Entity\SmartInvite\SmartInviteRecipient;
use App\Repository\BaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SmartInviteRecipient|null find($id, $lockMode = null, $lockVersion = null)
 * @method SmartInviteRecipient|null findOneBy(array $criteria, array $orderBy = null)
 * @method SmartInviteRecipient[]    findAll()
 * @method SmartInviteRecipient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SmartInviteRecipientRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SmartInviteRecipient::class);
    }
}
