<?php

namespace App\Repository;

use App\Entity\ContFemicida;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ContFemicida|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContFemicida|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContFemicida[]    findAll()
 * @method ContFemicida[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContFemicidaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContFemicida::class);
    }

    // /**
    //  * @return ContFemicida[] Returns an array of ContFemicida objects
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
    public function findOneBySomeField($value): ?ContFemicida
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
