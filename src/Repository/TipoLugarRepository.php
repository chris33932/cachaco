<?php

namespace App\Repository;

use App\Entity\TipoLugar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoLugar|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoLugar|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoLugar[]    findAll()
 * @method TipoLugar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoLugarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoLugar::class);
    }

    // /**
    //  * @return TipoLugar[] Returns an array of TipoLugar objects
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
    public function findOneBySomeField($value): ?TipoLugar
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
