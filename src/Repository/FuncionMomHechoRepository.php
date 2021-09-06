<?php

namespace App\Repository;

use App\Entity\FuncionMomHecho;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FuncionMomHecho|null find($id, $lockMode = null, $lockVersion = null)
 * @method FuncionMomHecho|null findOneBy(array $criteria, array $orderBy = null)
 * @method FuncionMomHecho[]    findAll()
 * @method FuncionMomHecho[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FuncionMomHechoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FuncionMomHecho::class);
    }

    // /**
    //  * @return FuncionMomHecho[] Returns an array of FuncionMomHecho objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FuncionMomHecho
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
