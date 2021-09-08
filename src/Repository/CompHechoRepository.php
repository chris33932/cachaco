<?php

namespace App\Repository;

use App\Entity\CompHecho;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompHecho|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompHecho|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompHecho[]    findAll()
 * @method CompHecho[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompHechoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompHecho::class);
    }

    // /**
    //  * @return CompHecho[] Returns an array of CompHecho objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CompHecho
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
