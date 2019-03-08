<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class BaseRepository extends ServiceEntityRepository
{
    public function persistAndFlush(object $object)
    {
        $this->getEntityManager()->persist($object);
        $this->getEntityManager()->flush();
    }
}