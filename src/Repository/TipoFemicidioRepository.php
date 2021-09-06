<?php

namespace App\Repository;

use App\Entity\TipoFemicidio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoFemicidio|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoFemicidio|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoFemicidio[]    findAll()
 * @method TipoFemicidio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoFemicidioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoFemicidio::class);
    }

    // /**
    //  * @return TipoFemicidio[] Returns an array of TipoFemicidio objects
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
    public function findOneBySomeField($value): ?TipoFemicidio
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
