<?php

namespace App\Repository;

use App\Entity\OrigenRegistro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrigenRegistro|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrigenRegistro|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrigenRegistro[]    findAll()
 * @method OrigenRegistro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrigenRegistroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrigenRegistro::class);
    }

    // /**
    //  * @return OrigenRegistro[] Returns an array of OrigenRegistro objects
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
    public function findOneBySomeField($value): ?OrigenRegistro
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
