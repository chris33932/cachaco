<?php

namespace App\Repository;

use App\Entity\TipoDomParticular;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoDomParticular|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoDomParticular|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoDomParticular[]    findAll()
 * @method TipoDomParticular[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoDomParticularRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoDomParticular::class);
    }

    // /**
    //  * @return TipoDomParticular[] Returns an array of TipoDomParticular objects
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
    public function findOneBySomeField($value): ?TipoDomParticular
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
