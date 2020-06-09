<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save($object, $flush = true)
    {
        $this->_em->persist($object);
        if (true === $flush) {
            $this->_em->flush();
        }
        return $object;
    }

    public function remove($object, $flush = true)
    {
        $this->_em->remove($object);
        if (true === $flush) {
            $this->_em->flush();
        }

        return $object;
    }
}