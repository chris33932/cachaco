<?php

namespace App\Repository;

use App\Entity\MecanismoMuerte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MecanismoMuerte|null find($id, $lockMode = null, $lockVersion = null)
 * @method MecanismoMuerte|null findOneBy(array $criteria, array $orderBy = null)
 * @method MecanismoMuerte[]    findAll()
 * @method MecanismoMuerte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MecanismoMuerteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MecanismoMuerte::class);
    }

    // /**
    //  * @return MecanismoMuerte[] Returns an array of MecanismoMuerte objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MecanismoMuerte
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
