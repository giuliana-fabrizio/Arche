<?php

namespace App\Repository;

use App\Entity\Section;
use App\Entity\Ue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Section>
 */
class SectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Section::class);
    }

       /**
        * @return Section[] Returns an array of Section objects
        */
       public function getSectionsWithPostsOrdered(Ue $ue): array
       {
            return $this->createQueryBuilder('s')
                ->leftJoin('s.posts', 'p')
                ->addSelect('p')
                ->andWhere('s.fk_ue = :ue')
                ->setParameter('ue', $ue)
                ->orderBy('s.ranking', 'ASC')
                ->addOrderBy('p.ranking', 'ASC')
                ->getQuery()
                ->getResult();
       }
}
