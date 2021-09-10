<?php

namespace App\Repository;

use App\Entity\DetalleHecho;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetalleHecho|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetalleHecho|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetalleHecho[]    findAll()
 * @method DetalleHecho[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetalleHechoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetalleHecho::class);
    }

    // /**
    //  * @return DetalleHecho[] Returns an array of DetalleHecho objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DetalleHecho
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
