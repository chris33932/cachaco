<?php

namespace App\Repository;

use App\Entity\EstadoIntox;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EstadoIntox|null find($id, $lockMode = null, $lockVersion = null)
 * @method EstadoIntox|null findOneBy(array $criteria, array $orderBy = null)
 * @method EstadoIntox[]    findAll()
 * @method EstadoIntox[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstadoIntoxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EstadoIntox::class);
    }

    // /**
    //  * @return EstadoIntox[] Returns an array of EstadoIntox objects
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
    public function findOneBySomeField($value): ?EstadoIntox
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
