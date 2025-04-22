<?php

namespace App\Repository;

use App\Entity\Ue;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ue>
 */
class UeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ue::class);
    }


    /**
        * @return User[] Returns an array of User objects
        */
    public function getAssociateUsers(Int $id_ue, array $roles) {
        return $this->createQueryBuilder('ue')
            ->join('ue.associates_users', 'u')
            ->select('u.firstname, u.lastname, u.email')
            ->where('ue.id = :id_ue')
            ->andWhere('u.roles in (:roles)')
            ->setParameter('id_ue', $id_ue)
            ->setParameter('roles', $roles)
            ->getQuery()
            ->getResult();
    }
}
