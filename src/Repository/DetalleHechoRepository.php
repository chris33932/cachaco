<?php

namespace App\Repository;

use App\Entity\DetalleHecho;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DetalleHecho|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetalleHecho|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetalleHecho[]    findAll()
 * @method DetalleHecho[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetalleHechoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetalleHecho::class);
    }
    public function findByVictimaId($victimaId){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('d, partial v.{id, nombre, apellido}, partial h.{id, nro_preventivo, mes, anio, lugar_ocu}')
            ->from('App:detalleHecho', 'd')
            ->innerJoin('d.hecho', 'h')
            ->innerJoin('d.victima', 'v')
            ->where($qb->expr()->eq('v.id', ':victimaId'));

        $qb->setParameter('victimaId', $victimaId);

        return $qb->getQuery()->getResult();

    }


    public function findByPresAutorId($presAutorId){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('d, partial a.{id, nombre, apellido}, partial h.{id, nro_preventivo, mes, anio, lugar_ocu}')
            ->from('App:detalleHecho', 'd')
            ->innerJoin('d.hecho', 'h')
            ->innerJoin('d.pres_autor', 'a')
            ->where($qb->expr()->eq('a.id', ':presAutorId'));

        $qb->setParameter('presAutorId', $presAutorId);

        return $qb->getQuery()->getResult();

    }






    public function findByHechoId($hechoId){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('d, partial v.{id, nombre, apellido}, partial v.{id, nombre, apellido},  partial p.{id, nombre, apellido}')
            ->from('App:detalleHecho', 'd')
            ->innerJoin('d.hecho', 'h')
            ->innerJoin('d.victima', 'v')
            ->innerJoin('d.pres_autor', 'p')
            ->where($qb->expr()->eq('h.id', ':hechoId'));

        $qb->setParameter('hechoId', $hechoId);

        return $qb->getQuery()->getResult();

    }











    // /**
    //  * @return DetalleHecho[] Returns an array of DetalleHecho objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DetalleHecho
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
