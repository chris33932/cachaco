<?php

namespace App\Repository;

use App\Entity\TipoPerArma;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoPerArma|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoPerArma|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoPerArma[]    findAll()
 * @method TipoPerArma[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoPerArmaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoPerArma::class);
    }

    // /**
    //  * @return TipoPerArma[] Returns an array of TipoPerArma objects
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
    public function findOneBySomeField($value): ?TipoPerArma
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
