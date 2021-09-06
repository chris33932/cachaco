<?php

namespace App\Repository;

use App\Entity\NivelInstruccion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NivelInstruccion|null find($id, $lockMode = null, $lockVersion = null)
 * @method NivelInstruccion|null findOneBy(array $criteria, array $orderBy = null)
 * @method NivelInstruccion[]    findAll()
 * @method NivelInstruccion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NivelInstruccionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NivelInstruccion::class);
    }

    // /**
    //  * @return NivelInstruccion[] Returns an array of NivelInstruccion objects
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
    public function findOneBySomeField($value): ?NivelInstruccion
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
