<?php

namespace App\Repository;

use App\Entity\Etnia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Etnia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etnia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etnia[]    findAll()
 * @method Etnia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtniaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etnia::class);
    }

    // /**
    //  * @return Etnia[] Returns an array of Etnia objects
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
    public function findOneBySomeField($value): ?Etnia
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
