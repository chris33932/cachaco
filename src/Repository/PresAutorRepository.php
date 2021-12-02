<?php

namespace App\Repository;

use App\Entity\PresAutor;
use Doctrine\ORM\Query\ResultSetMapping;
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


    public function presAutorPorSexo($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
                SELECT 
            sexo.descripcion AS descripcion,
            COUNT( DISTINCT	pres_autor.id) AS cantidad
                
            FROM
                hecho
                INNER JOIN
                detalle_hecho
                ON 
                    hecho.id = detalle_hecho.hecho_id
                INNER JOIN
                pres_autor
                ON 
                    pres_autor.id = detalle_hecho.pres_autor_id
                INNER JOIN
                sexo
                ON 
                    pres_autor.sexo_id = sexo.id
                WHERE hecho.fecha > :fechaDesde
                    AND hecho.fecha < :fechaHasta
                    GROUP BY
                    sexo.descripcion
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


    public function presAutorPorGenero($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
                SELECT 
            genero.descripcion AS descripcion,
            COUNT( DISTINCT	pres_autor.id) AS cantidad
                
            FROM
                hecho
                INNER JOIN
                detalle_hecho
                ON 
                    hecho.id = detalle_hecho.hecho_id
                INNER JOIN
                pres_autor
                ON 
                    pres_autor.id = detalle_hecho.pres_autor_id
                LEFT JOIN
                genero
                ON 
                    pres_autor.genero_id = genero.id
                WHERE hecho.fecha >= :fechaDesde
                    AND hecho.fecha <= :fechaHasta
                    GROUP BY
                    genero.descripcion
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





    public function presAutorPorRango($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
                SELECT 
                rango_etario.descripcion AS descripcion,
	            COUNT( DISTINCT detalle_hecho.pres_autor_id) cantidad
            
            FROM
                hecho
                INNER JOIN
                detalle_hecho
                ON 
                    hecho.id = detalle_hecho.hecho_id
                INNER JOIN
                pres_autor
                ON 
                    detalle_hecho.pres_autor_id = pres_autor.id
                LEFT JOIN
                rango_etario
                ON 
                pres_autor.rango_etario_id = rango_etario.id
                WHERE hecho.fecha >= :fechaDesde
                AND hecho.fecha <= :fechaHasta
                GROUP BY
                rango_etario.descripcion
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


    public function presAutorPorDepartamento($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
            SELECT 
            departamento.descripcion AS descripcion,
            COUNT( DISTINCT detalle_hecho.pres_autor_id) AS cantidad

	
            FROM
            hecho
            INNER JOIN
            detalle_hecho
            ON 
                hecho.id = detalle_hecho.hecho_id
            INNER JOIN
            pres_autor
            ON 
                detalle_hecho.pres_autor_id = pres_autor.id
            LEFT JOIN
            departamento
            ON 
                hecho.departamento_id = departamento.id 
                WHERE hecho.fecha >= :fechaDesde
                AND hecho.fecha <= :fechaHasta
                GROUP BY
                departamento.descripcion
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



    public function presAutorPorLocalidad($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
        SElECT
                localidad.nombre AS descripcion, 
	            COUNT( DISTINCT detalle_hecho.pres_autor_id) AS cantidad

                FROM
                hecho
                INNER JOIN
                detalle_hecho
                ON 
                    hecho.id = detalle_hecho.hecho_id
                INNER JOIN
                pres_autor
                ON 
                    detalle_hecho.pres_autor_id = pres_autor.id
                INNER JOIN
                localidad
                ON 
                hecho.localidad_id = localidad.id
                WHERE hecho.fecha >= :fechaDesde
                AND hecho.fecha <= :fechaHasta
                GROUP BY
                localidad.nombre
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


    public function presAutorPorEdadLegal($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
            SELECT pres_autor.edad_legal AS descripcion,
            COUNT( DISTINCT detalle_hecho.pres_autor_id) AS cantidad
            FROM
            hecho
            INNER JOIN
            detalle_hecho
            ON 
                hecho.id = detalle_hecho.hecho_id
            INNER JOIN
            pres_autor
            ON 
		    detalle_hecho.pres_autor_id = pres_autor.id
            WHERE hecho.fecha >= :fechaDesde
            AND hecho.fecha <= :fechaHasta
            GROUP BY pres_autor.edad_legal
            
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



    public function presAutorPorDia($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
            SELECT
	        hecho.dia_ocu AS descripcion, 
	        COUNT( DISTINCT detalle_hecho.pres_autor_id)
        FROM
            hecho
            INNER JOIN
            detalle_hecho
            ON 
                hecho.id = detalle_hecho.hecho_id
            INNER JOIN
            pres_autor
            ON 
            detalle_hecho.pres_autor_id = pres_autor.id
            WHERE hecho.fecha >= :fechaDesde
            AND hecho.fecha <= :fechaHasta
            GROUP BY hecho.dia_ocu
            
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




    public function presAutorPorMes($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
            SELECT hecho.mes AS descripcion,
            COUNT( DISTINCT detalle_hecho.pres_autor_id) cantidad 
	
        FROM
            hecho
            INNER JOIN
            detalle_hecho
            ON 
                hecho.id = detalle_hecho.hecho_id
            INNER JOIN
            pres_autor
            ON 
    		detalle_hecho.pres_autor_id = pres_autor.id
            WHERE hecho.fecha >= :fechaDesde
            AND hecho.fecha <= :fechaHasta
            GROUP BY hecho.mes
            
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
