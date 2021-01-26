<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * Attempts to find a post into the DB, if it can't find it, it will create a new one instead
     *
     * @param string $slug
     *
     * @return Post|null
     */
    public function findOrNew(string $slug): ?Post
    {
        if ($slug) {
            return $this->findOneBy(['slug' => $slug]);
        }

        return new Post();
    }

    /**
     * Deletes a Post from the DB
     *
     * @param string $slug
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(string $slug): void
    {
        $post = $this->findOneBy(['slug' => $slug]);

        $this->remove($post);
    }
}
