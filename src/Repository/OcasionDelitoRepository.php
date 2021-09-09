<?php

namespace App\Repository;

use App\Entity\OcasionDelito;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OcasionDelito|null find($id, $lockMode = null, $lockVersion = null)
 * @method OcasionDelito|null findOneBy(array $criteria, array $orderBy = null)
 * @method OcasionDelito[]    findAll()
 * @method OcasionDelito[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OcasionDelitoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OcasionDelito::class);
    }

    // /**
    //  * @return OcasionDelito[] Returns an array of OcasionDelito objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OcasionDelito
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
