<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * Attempts to find a new category into the DB, if it can't find it, it will create a new one instead
     *
     * @param string $slug
     *
     * @return Category|null
     */
    public function findOrNew(string $slug)
    {
        if ($slug) {
            return $this->findOneBy(['slug' => $slug]);
        }

        return new Category();
    }

    /**
     * Deletes an Entity from the DB
     *
     * @param string $slug
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(string $slug): void
    {
        $category = $this->findOneBy(['slug' => $slug]);

        $this->remove($category);
    }
}
