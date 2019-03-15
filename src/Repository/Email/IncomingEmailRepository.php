<?php

namespace App\Repository\Email;

use App\Entity\Email\IncomingEmail;
use App\Repository\BaseRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method IncomingEmail|null find($id, $lockMode = null, $lockVersion = null)
 * @method IncomingEmail|null findOneBy(array $criteria, array $orderBy = null)
 * @method IncomingEmail[]    findAll()
 * @method IncomingEmail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncomingEmailRepository extends BaseRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IncomingEmail::class);
    }
}
