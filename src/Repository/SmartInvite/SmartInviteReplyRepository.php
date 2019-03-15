<?php

namespace App\Repository\SmartInvite;

use App\Entity\SmartInvite\SmartInviteReply;
use App\Repository\BaseRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SmartInviteReply|null find($id, $lockMode = null, $lockVersion = null)
 * @method SmartInviteReply|null findOneBy(array $criteria, array $orderBy = null)
 * @method SmartInviteReply[]    findAll()
 * @method SmartInviteReply[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SmartInviteReplyRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SmartInviteReply::class);
    }
}
