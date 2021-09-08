<?php

namespace App\Repository;

use App\Entity\EntRecepDenuncia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EntRecepDenuncia|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntRecepDenuncia|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntRecepDenuncia[]    findAll()
 * @method EntRecepDenuncia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntRecepDenunciaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntRecepDenuncia::class);
    }

    // /**
    //  * @return EntRecepDenuncia[] Returns an array of EntRecepDenuncia objects
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
    public function findOneBySomeField($value): ?EntRecepDenuncia
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
