<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

abstract class AbstractRepository extends ServiceEntityRepository
{
    /**
     * Saves an entity into the DB
     *
     * @param object $entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save($entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * Delete an entity from the DB
     *
     * @param object $entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove($entity): void
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }
}
