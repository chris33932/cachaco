<?php

namespace App\Repository;

use App\Entity\CondicionActividad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CondicionActividad|null find($id, $lockMode = null, $lockVersion = null)
 * @method CondicionActividad|null findOneBy(array $criteria, array $orderBy = null)
 * @method CondicionActividad[]    findAll()
 * @method CondicionActividad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CondicionActividadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CondicionActividad::class);
    }

    // /**
    //  * @return CondicionActividad[] Returns an array of CondicionActividad objects
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
    public function findOneBySomeField($value): ?CondicionActividad
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
