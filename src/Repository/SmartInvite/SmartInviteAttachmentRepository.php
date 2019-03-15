<?php

namespace App\Repository\SmartInvite;

use App\Entity\SmartInvite\SmartInviteAttachment;
use App\Repository\BaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SmartInviteAttachment|null find($id, $lockMode = null, $lockVersion = null)
 * @method SmartInviteAttachment|null findOneBy(array $criteria, array $orderBy = null)
 * @method SmartInviteAttachment[]    findAll()
 * @method SmartInviteAttachment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SmartInviteAttachmentRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SmartInviteAttachment::class);
    }
}
