<?php

namespace App\Repository;

use App\Entity\PresAutor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PresAutor|null find($id, $lockMode = null, $lockVersion = null)
 * @method PresAutor|null findOneBy(array $criteria, array $orderBy = null)
 * @method PresAutor[]    findAll()
 * @method PresAutor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PresAutorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PresAutor::class);
    }
    public function findByNombreOId($query)
    {
        $qb = $this->createQueryBuilder('p');

        $qb->select('p')
            ->where(
                $qb->expr()->orX(
                    $qb->expr()->like('p.id', ':query'),
                    $qb->expr()->like('p.nombre', ':query'),
                    $qb->expr()->like('p.apellido', ':query')
                )
            )->orderBy('p.apellido', 'ASC');
        $qb->setParameter('query', $query.'%');

        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return PresAutor[] Returns an array of PresAutor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PresAutor
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
