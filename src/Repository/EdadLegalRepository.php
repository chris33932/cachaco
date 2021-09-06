<?php

namespace App\Repository;

use App\Entity\EdadLegal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EdadLegal|null find($id, $lockMode = null, $lockVersion = null)
 * @method EdadLegal|null findOneBy(array $criteria, array $orderBy = null)
 * @method EdadLegal[]    findAll()
 * @method EdadLegal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EdadLegalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EdadLegal::class);
    }

    // /**
    //  * @return EdadLegal[] Returns an array of EdadLegal objects
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
    public function findOneBySomeField($value): ?EdadLegal
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
