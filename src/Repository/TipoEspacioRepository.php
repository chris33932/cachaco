<?php

namespace App\Repository;

use App\Entity\TipoEspacio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TipoEspacio|null find($id, $lockMode = null, $lockVersion = null)
 * @method TipoEspacio|null findOneBy(array $criteria, array $orderBy = null)
 * @method TipoEspacio[]    findAll()
 * @method TipoEspacio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TipoEspacioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TipoEspacio::class);
    }

    // /**
    //  * @return TipoEspacio[] Returns an array of TipoEspacio objects
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
    public function findOneBySomeField($value): ?TipoEspacio
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
