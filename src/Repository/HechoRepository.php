<?php

namespace App\Repository;

use App\Entity\Hecho;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hecho|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hecho|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hecho[]    findAll()
 * @method Hecho[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HechoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hecho::class);
    }

    // /**
    //  * @return Hecho[] Returns an array of Hecho objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hecho
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
