<?php

namespace App\Repository;

use App\Entity\EstadoPolicial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EstadoPolicial|null find($id, $lockMode = null, $lockVersion = null)
 * @method EstadoPolicial|null findOneBy(array $criteria, array $orderBy = null)
 * @method EstadoPolicial[]    findAll()
 * @method EstadoPolicial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstadoPolicialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EstadoPolicial::class);
    }

    // /**
    //  * @return EstadoPolicial[] Returns an array of EstadoPolicial objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EstadoPolicial
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
