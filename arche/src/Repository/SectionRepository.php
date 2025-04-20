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

       /**
        * @return Section[] Returns an array of Section objects
        */
       public function getSectionsToUpdateRanking(Ue $ue, Int $id_section, Int $start_ranking, Int $stop_ranking): array
       {
            $request = $this->createQueryBuilder('s')
                ->where('s.fk_ue = :ue')
                ->andWhere('s.id != :id_section');

            if ($start_ranking < $stop_ranking) {
                $request
                    ->andWhere('s.ranking > :start_ranking')
                    ->andWhere('s.ranking <= :stop_ranking');
            } else {
                $request
                    ->andWhere('s.ranking < :start_ranking')
                    ->andWhere('s.ranking >= :stop_ranking');
            }
            return $request
                ->setParameter('ue', $ue)
                ->setParameter('id_section', $id_section)
                ->setParameter('start_ranking', $start_ranking)
                ->setParameter('stop_ranking', $stop_ranking)
                ->getQuery()
                ->getResult();
       }
}
