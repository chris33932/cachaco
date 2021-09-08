<?php

namespace App\Repository;

use App\Entity\SitProcesal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SitProcesal|null find($id, $lockMode = null, $lockVersion = null)
 * @method SitProcesal|null findOneBy(array $criteria, array $orderBy = null)
 * @method SitProcesal[]    findAll()
 * @method SitProcesal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SitProcesalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SitProcesal::class);
    }

    // /**
    //  * @return SitProcesal[] Returns an array of SitProcesal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SitProcesal
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
