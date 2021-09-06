<?php

namespace App\Repository;

use App\Entity\RangoEtario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RangoEtario|null find($id, $lockMode = null, $lockVersion = null)
 * @method RangoEtario|null findOneBy(array $criteria, array $orderBy = null)
 * @method RangoEtario[]    findAll()
 * @method RangoEtario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RangoEtarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RangoEtario::class);
    }

    // /**
    //  * @return RangoEtario[] Returns an array of RangoEtario objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RangoEtario
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
