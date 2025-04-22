<?php

namespace App\Repository;

use App\Entity\Post;
use App\Entity\Section;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
        * @return Post[] Returns an array of Section objects
        */
    public function getPostsOrdered(Section $section): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.fk_section = :section')
            ->setParameter('section', $section)
            ->orderBy('p.ranking', 'ASC')
            ->getQuery()
            ->getResult();
    }


    /**
        * @return Section[] Returns an array of Section objects
        */
    public function getPostsToUpdateRanking(Section $section, Int $id_post, Int $start_ranking, Int $stop_ranking): array
    {
        $request = $this->createQueryBuilder('p')
            ->where('p.fk_section = :section')
            ->andWhere('p.id != :id_post');

        if ($start_ranking < $stop_ranking) {
            $request
                ->andWhere('p.ranking > :start_ranking')
                ->andWhere('p.ranking <= :stop_ranking');
        } else {
            $request
                ->andWhere('p.ranking < :start_ranking')
                ->andWhere('p.ranking >= :stop_ranking');
        }
        return $request
            ->setParameter('section', $section)
            ->setParameter('id_post', $id_post)
            ->setParameter('start_ranking', $start_ranking)
            ->setParameter('stop_ranking', $stop_ranking)
            ->getQuery()
            ->getResult();
    }


    /**
        * @return Section[] Returns an array of Section objects
        */
    public function countPosts(Section $section): int
    {
        return $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->where('p.fk_section = :section')
            ->setParameter('section', $section)
            ->getQuery()
            ->getSingleScalarResult();;
    }
}
