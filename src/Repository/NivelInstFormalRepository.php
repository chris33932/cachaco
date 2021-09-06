<?php

namespace App\Repository;

use App\Entity\NivelInstFormal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NivelInstFormal|null find($id, $lockMode = null, $lockVersion = null)
 * @method NivelInstFormal|null findOneBy(array $criteria, array $orderBy = null)
 * @method NivelInstFormal[]    findAll()
 * @method NivelInstFormal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NivelInstFormalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NivelInstFormal::class);
    }

    // /**
    //  * @return NivelInstFormal[] Returns an array of NivelInstFormal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NivelInstFormal
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
