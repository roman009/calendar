<?php

namespace App\Repository\Email;

use App\Entity\Email\IncomingEmailAttachment;
use App\Entity\Email\IncomingEmail;
use App\Repository\BaseRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IncomingEmailAttachment|null find($id, $lockMode = null, $lockVersion = null)
 * @method IncomingEmailAttachment|null findOneBy(array $criteria, array $orderBy = null)
 * @method IncomingEmailAttachment[]    findAll()
 * @method IncomingEmailAttachment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttachmentRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IncomingEmailAttachment::class);
    }
}
