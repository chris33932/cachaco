<?php

namespace App\Repository;

use App\Entity\SituacionArma;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SituacionArma|null find($id, $lockMode = null, $lockVersion = null)
 * @method SituacionArma|null findOneBy(array $criteria, array $orderBy = null)
 * @method SituacionArma[]    findAll()
 * @method SituacionArma[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SituacionArmaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SituacionArma::class);
    }

    // /**
    //  * @return SituacionArma[] Returns an array of SituacionArma objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SituacionArma
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
