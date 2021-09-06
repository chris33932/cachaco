<?php

namespace App\Repository;

use App\Entity\RepGeografica;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RepGeografica|null find($id, $lockMode = null, $lockVersion = null)
 * @method RepGeografica|null findOneBy(array $criteria, array $orderBy = null)
 * @method RepGeografica[]    findAll()
 * @method RepGeografica[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepGeograficaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RepGeografica::class);
    }

    // /**
    //  * @return RepGeografica[] Returns an array of RepGeografica objects
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
    public function findOneBySomeField($value): ?RepGeografica
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
