<?php

namespace App\Repository;

use AppBundle\Form\RangoFechaType;
use Doctrine\ORM\Query\ResultSetMapping;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


use App\Entity\Hecho;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hecho|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hecho|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hecho[]    findAll()
 * @method Hecho[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HechoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hecho::class);
    }
    public function findBynroPreventivoOId($query)
    {
        $qb = $this->createQueryBuilder('h');

        $qb->select('h')
            ->where(
                $qb->expr()->orX(
                    $qb->expr()->like('h.id', ':query'),
                    $qb->expr()->like('h.anio', ':query'),
                    $qb->expr()->like('h.nro_preventivo', ':query')
                )
            )->orderBy('h.id', 'ASC');
        $qb->setParameter('query', $query.'%');

        return $qb->getQuery()->getResult();
    }

    
        public function hechosPorTipologia($fechaDesde, $fechaHasta){
         $sql = <<<'SQL'
                    SELECT
                    tipologia.descripcion AS descripcion,
                     COUNT(hecho.id) AS cantidad
                    FROM hecho 
                    hecho
                    INNER JOIN
                    tipologia
                    ON 
                    hecho.tipologia_id = tipologia.id
                    WHERE hecho.fecha > :fechaDesde
                        AND hecho.fecha < :fechaHasta
                        GROUP BY
                        tipologia.descripcion
            SQL;
    
            $rsm = new ResultSetMapping();
    
            $rsm->addScalarResult('descripcion', 'descripcion');
            $rsm->addScalarResult('cantidad', 'cantidad');
           
    
            $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);
    
            $fechaDesdeCorregida = clone $fechaDesde;
            $fechaHastaCorregida = clone $fechaHasta;
    
            $fechaDesdeCorregida->setTime(0, 0, 0);
            $fechaHastaCorregida->add(new \DateInterval('P1D'))->setTime(0, 0, 0);
    
            $query->setParameter(':fechaDesde', $fechaDesdeCorregida)
                ->setParameter(':fechaHasta', $fechaHastaCorregida);
    
            return $query->getArrayResult();
        }

        
        public function hechosPorLodalidad($fechaDesde, $fechaHasta){
            $sql = <<<'SQL'
                       SELECT
                       localidad.nombre AS descripcion,
                        COUNT(hecho.id) AS cantidad
                       FROM hecho 
                       hecho
                       INNER JOIN
                       localidad
                       ON 
                       hecho.localidad_id = localidad.id
                       WHERE hecho.fecha > :fechaDesde
                           AND hecho.fecha < :fechaHasta
                           GROUP BY
                           localidad.id
                           ORDER BY cantidad
               SQL;
       
               $rsm = new ResultSetMapping();
       
               $rsm->addScalarResult('descripcion', 'descripcion');
               $rsm->addScalarResult('cantidad', 'cantidad');
              
       
               $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);
       
               $fechaDesdeCorregida = clone $fechaDesde;
               $fechaHastaCorregida = clone $fechaHasta;
       
               $fechaDesdeCorregida->setTime(0, 0, 0);
               $fechaHastaCorregida->add(new \DateInterval('P1D'))->setTime(0, 0, 0);
       
               $query->setParameter(':fechaDesde', $fechaDesdeCorregida)
                   ->setParameter(':fechaHasta', $fechaHastaCorregida);
       
               return $query->getArrayResult();
           }

    

    // /**
    //  * @return Hecho[] Returns an array of Hecho objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hecho
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
