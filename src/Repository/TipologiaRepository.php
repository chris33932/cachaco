<?php

namespace App\Repository;

use App\Entity\Tipologia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tipologia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tipologia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tipologia[]    findAll()
 * @method Tipologia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipologiaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tipologia::class);
    }

    // /**
    //  * @return Tipologia[] Returns an array of Tipologia objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tipologia
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
