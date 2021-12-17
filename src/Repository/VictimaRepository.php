<?php

namespace App\Repository;

use App\Entity\Victima;

use AppBundle\Form\RangoFechaType;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Victima|null find($id, $lockMode = null, $lockVersion = null)
 * @method Victima|null findOneBy(array $criteria, array $orderBy = null)
 * @method Victima[]    findAll()
 * @method Victima[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VictimaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Victima::class);
    }

    public function findByNombreOId($query)
    {
        $qb = $this->createQueryBuilder('v');

        $qb->select('v')
            ->where(
                $qb->expr()->orX(
                    $qb->expr()->like('v.id', ':query'),
                    $qb->expr()->like('v.nombre', ':query'),
                    $qb->expr()->like('v.apellido', ':query')
                )
            )->orderBy('v.apellido', 'ASC');
        $qb->setParameter('query', $query.'%');

        return $qb->getQuery()->getResult();
    }



    public function victimasPorDepartamento($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
                SELECT
                    departamento.descripcion	 AS descripcion,
                    COUNT(DISTINCT detalle_hecho.victima_id) AS cantidad
                FROM 
                hecho
	            INNER JOIN
	            departamento
	            ON 
		        hecho.departamento_id = departamento.id
	            INNER JOIN
	            detalle_hecho
	            ON 
		        hecho.id = detalle_hecho.hecho_id
	            INNER JOIN
	            victima
	            ON 
		        
		        detalle_hecho.victima_id = victima.id
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

    

    public function victimasPorLocalidad($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
        SELECT
        localidad.nombre AS descripcion, 
        COUNT(DISTINCT detalle_hecho.victima_id) AS cantidad

        FROM
        hecho
        INNER JOIN
        localidad
        ON 
            hecho.localidad_id = localidad.id
        INNER JOIN
        detalle_hecho
        ON 
            hecho.id = detalle_hecho.hecho_id
        INNER JOIN
        victima
        ON 
            detalle_hecho.victima_id = victima.id
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



    public function victimasPorRangoEtario($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
                SELECT
                    rango_etario.descripcion	 AS descripcion,
                    COUNT(DISTINCT victima_id) AS cantidad
                FROM 
                hecho
	            INNER JOIN
	            detalle_hecho
	            ON 
		        hecho.id = detalle_hecho.hecho_id
	            INNER JOIN
	            victima
	            ON 
		        victima.id = detalle_hecho.victima_id
	            INNER JOIN
	            rango_etario
	            ON 
                victima.rango_etario_id = rango_etario.id
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

    public function victimasPorEdadLegal($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
                SELECT
                    edad_legal.descripcion	 AS descripcion,
                    COUNT(DISTINCT victima_id) AS cantidad
                    FROM
                    hecho
                    INNER JOIN
                    detalle_hecho
                    ON 
                        hecho.id = detalle_hecho.hecho_id
                    INNER JOIN
                    victima
                    ON 
                        victima.id = detalle_hecho.victima_id
                    INNER JOIN
                    edad_legal
                    ON 
		        victima.edad_legal_id = edad_legal.id
                WHERE hecho.fecha >= :fechaDesde
                    AND hecho.fecha <= :fechaHasta
                    GROUP BY
                edad_legal.descripcion
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


    public function victimasPorMes($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
                SELECT
                    mes	  AS descripcion,
                    COUNT(DISTINCT detalle_hecho.victima_id) AS cantidad
                    FROM
                    detalle_hecho
	                INNER JOIN
	                hecho
	                ON 
		            detalle_hecho.hecho_id = hecho.id
                    INNER JOIN
                    victima
                    ON 
            		detalle_hecho.victima_id = victima.id
                WHERE hecho.fecha >= :fechaDesde
                    AND hecho.fecha <= :fechaHasta
                    GROUP BY mes
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


    public function victimasPorDia($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
                SELECT
                    dia_ocu	 AS descripcion,
                    COUNT(DISTINCT detalle_hecho.victima_id) AS cantidad
                    FROM
                    detalle_hecho
	                INNER JOIN
	                hecho
	                ON 
		            detalle_hecho.hecho_id = hecho.id
                    INNER JOIN
                    victima
                    ON 
            		detalle_hecho.victima_id = victima.id
                WHERE hecho.fecha >= :fechaDesde
                    AND hecho.fecha <= :fechaHasta
                    GROUP BY
                    dia_ocu
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


    public function victimasPorSexo($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
                SELECT
                    sexo.descripcion  AS descripcion,
                    COUNT(DISTINCT detalle_hecho.victima_id) AS cantidad
                    FROM
                    hecho
	                INNER JOIN
	                detalle_hecho
	                ON 
		            hecho.id = detalle_hecho.hecho_id
                    INNER JOIN
                    victima
                    ON 
            		detalle_hecho.victima_id = victima.id
                    INNER JOIN
                    sexo
                    ON 
		           victima.sexo_id = sexo.id
                WHERE hecho.fecha >= :fechaDesde
                    AND hecho.fecha <= :fechaHasta
                    GROUP BY sexo.descripcion
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



    public function victimasPorGenero($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
                SELECT
                    genero.descripcion  AS descripcion,
                    COUNT(DISTINCT detalle_hecho.victima_id) AS cantidad
                    FROM
                    detalle_hecho
	                INNER JOIN
	                hecho
	                ON 
		            detalle_hecho.hecho_id = hecho.id
                    INNER JOIN
                    victima
                    ON 
            		detalle_hecho.victima_id = victima.id
                    INNER JOIN
                    genero
                    ON 
	            	genero.id = victima.genero_id 
                WHERE hecho.fecha >= :fechaDesde
                    AND hecho.fecha <= :fechaHasta
                    GROUP BY genero.descripcion
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

    public function victimasPorMecanismo($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
                SELECT
        mecanismo_muerte.descripcion AS descripcion,
        COUNT( DISTINCT detalle_hecho.victima_id) AS cantidad
            
        FROM
            hecho
            INNER JOIN
            detalle_hecho
            ON 
                hecho.id = detalle_hecho.hecho_id
            INNER JOIN
            victima
            ON 
                detalle_hecho.victima_id = victima.id
            LEFT JOIN
            mecanismo_muerte
            ON 
            victima.mecanismo_muerte_id = mecanismo_muerte.id
            WHERE hecho.fecha >= :fechaDesde
            AND hecho.fecha <= :fechaHasta
            GROUP BY mecanismo_muerte.descripcion
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

    public function victimasPorClase($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
                SELECT

                victima.fuerza_seg AS descripcion,
                COUNT(DISTINCT detalle_hecho.victima_id) AS cantidad
                FROM
                hecho
                INNER JOIN
                detalle_hecho
                ON 
                    hecho.id = detalle_hecho.hecho_id
                INNER JOIN
                victima
                ON 
                    detalle_hecho.victima_id = victima.id
                    WHERE hecho.fecha >= :fechaDesde
                    AND hecho.fecha <= :fechaHasta
                    GROUP BY victima.fuerza_seg
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


    // Cantidad de victims por tipo arma
    public function victimasPorTipoArma($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
            SELECT
            tipo_arma.descripcion AS descripcion,
            COUNT( DISTINCT victima.id) AS cantidad
	
            FROM
	        hecho
            INNER JOIN
            detalle_hecho
            ON 
                hecho.id = detalle_hecho.hecho_id
            INNER JOIN
            victima
            ON 
                detalle_hecho.victima_id = victima.id
            LEFT JOIN
            tipo_arma
            ON 
                victima.tipo_arma_id = tipo_arma.id
                        WHERE hecho.fecha >= :fechaDesde
                        AND hecho.fecha <= :fechaHasta
                        GROUP BY tipo_arma.descripcion
           
                  

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


// DISTRIBUCION DE VICTIMAS POR VINCULO CON AUTOR

public function victimasPorVinculo($fechaDesde, $fechaHasta){
    $sql = <<<'SQL'
        SELECT
        DISTINCT 
        detalle_hecho.victima_id AS victima, 
        detalle_hecho.pres_autor_id AS autor,
        hecho.id AS hecho,
        detalle_hecho.vinculo AS vinculo, 
        detalle_hecho.vinculo_familiar AS vinculofliar, 
        detalle_hecho.vinculo_familiar_otro AS vinculofliarotro, 
        detalle_hecho.vinculo_no_familiar AS vinculonofliar, 
        detalle_hecho.vinculo_no_familiar_otro AS vinculonofliarotro,
        hecho.fecha AS fecha

        FROM
	    hecho
        INNER JOIN
        detalle_hecho
        ON 
            hecho.id = detalle_hecho.hecho_id
        INNER JOIN
        victima
        ON 
		detalle_hecho.victima_id = victima.id

        WHERE hecho.fecha >= :fechaDesde
        AND hecho.fecha <= :fechaHasta
        ORDER BY
        	    detalle_hecho.vinculo
              

SQL;
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('victima', 'victima');
        $rsm->addScalarResult('autor', 'autor');
        $rsm->addScalarResult('victima', 'victima');
        $rsm->addScalarResult('hecho', 'hecho');
        $rsm->addScalarResult('vinculo', 'vinculo');
        $rsm->addScalarResult('vinculofliar', 'vinculofliar');
        $rsm->addScalarResult('vinculofliarotro', 'vinculofliarotro');
        $rsm->addScalarResult('vinculonofliar', 'vinculonofliar');
        $rsm->addScalarResult('vinculonofliarotro', 'vinculonofliarotro');
        $rsm->addScalarResult('fecha', 'fecha');

        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);

        $fechaDesdeCorregida = clone $fechaDesde;
        $fechaHastaCorregida = clone $fechaHasta;

        $fechaDesdeCorregida->setTime(0, 0, 0);
        $fechaHastaCorregida->add(new \DateInterval('P1D'))->setTime(0, 0, 0);

        $query->setParameter(':fechaDesde', $fechaDesdeCorregida)
            ->setParameter(':fechaHasta', $fechaHastaCorregida);

        return $query->getArrayResult();
}





    // Cantidad de femicidios con exceso en el uso de la violencia letal = "Esta por presunto autor distinto,
    // para hacer consultas sobre los mismos, si lo hago por victima se pierde el registro de los autores"
    public function victimasPorExc($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
            SELECT DISTINCT
            detalle_hecho.pres_autor_id AS PresAutorId,
            hecho.id AS hecho, 
            victima.id AS victima, 
            sexo.descripcion AS sexo, 
            victima.femicidio AS femicidio,
            tipo_femicidio.descripcion AS tipoFemicidio, 
            victima.violencia_exc AS overkill, 
            tipo_dom_particular.descripcion AS domicilio, 
            detalle_hecho.vinculo AS vinculo, 
            detalle_hecho.vinculo_familiar AS vinculoTipo, 
            detalle_hecho.vinculo_familiar_otro AS vinculoTipoOtro, 
            detalle_hecho.conviviente AS conviviente, 
            departamento.descripcion AS departamento, 
            localidad.nombre AS localidad, 
            hecho.fecha AS fecha

    FROM
        hecho
        INNER JOIN
        detalle_hecho
        ON 
            hecho.id = detalle_hecho.hecho_id
        INNER JOIN
        victima
        ON 
            detalle_hecho.victima_id = victima.id
        INNER JOIN
        sexo
        ON 
            victima.sexo_id = sexo.id
        LEFT JOIN
        tipo_dom_particular
        ON 
            hecho.dom_part_ocu_id = tipo_dom_particular.id
        INNER JOIN
        departamento
        ON 
            hecho.departamento_id = departamento.id
        INNER JOIN
        localidad
        ON 
		hecho.localidad_id = localidad.id
        INNER JOIN
	    tipo_femicidio
     	ON 
		victima.tipo_femicidio_id = tipo_femicidio.id
            WHERE hecho.fecha >= :fechaDesde
            AND hecho.fecha <= :fechaHasta
            HAVING femicidio = 'Si'
            ORDER BY detalle_hecho.victima_id DESC
                  

SQL;
    $rsm = new ResultSetMapping();
    $rsm->addScalarResult('hecho', 'hecho');
    $rsm->addScalarResult('sexo', 'sexo');
    $rsm->addScalarResult('victima', 'victima');
    $rsm->addScalarResult('femicidio', 'femicidio');
    $rsm->addScalarResult('tipoFemicidio', 'tipoFemicidio'); 
    $rsm->addScalarResult('domicilio', 'domicilio');
    $rsm->addScalarResult('fecha', 'fecha');
    $rsm->addScalarResult('overkill', 'overkill');
    $rsm->addScalarResult('vinculo', 'vinculo');
    $rsm->addScalarResult('vinculoTipo', 'vinculoTipo');
    $rsm->addScalarResult('conviviente', 'conviviente');
    $rsm->addScalarResult('vinculoTipoOtro', 'vinculoTipoOtro');
    $rsm->addScalarResult('departamento', 'departamento');
    $rsm->addScalarResult('localidad', 'localidad');
    
    
   

    $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);

    $fechaDesdeCorregida = clone $fechaDesde;
    $fechaHastaCorregida = clone $fechaHasta;

    $fechaDesdeCorregida->setTime(0, 0, 0);
    $fechaHastaCorregida->add(new \DateInterval('P1D'))->setTime(0, 0, 0);

    $query->setParameter(':fechaDesde', $fechaDesdeCorregida)
        ->setParameter(':fechaHasta', $fechaHastaCorregida);

    return $query->getArrayResult();
}



// Cantidad de femicidios agrupado por departamento y tipo femicidio
  public function femicidiosDepartamento($fechaDesde, $fechaHasta){
    $sql = <<<'SQL'
        SELECT
            departamento.descripcion	 AS descripcion, tipo_femicidio.descripcion AS tipoFemicidio,
            COUNT(DISTINCT detalle_hecho.victima_id) AS cantidad
        FROM 
        hecho
        INNER JOIN
        departamento
        ON 
        hecho.departamento_id = departamento.id
        INNER JOIN
        detalle_hecho
        ON 
        hecho.id = detalle_hecho.hecho_id
        INNER JOIN
        victima
        ON 
        detalle_hecho.victima_id = victima.id
        INNER JOIN
        tipo_femicidio
        ON 
		victima.tipo_femicidio_id = tipo_femicidio.id 
        WHERE hecho.fecha >= :fechaDesde
            AND hecho.fecha <= :fechaHasta
            AND femicidio = 'Si'
            GROUP BY  departamento.descripcion, tipo_femicidio.descripcion
          
SQL;

        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('descripcion', 'descripcion');
        $rsm->addScalarResult('tipoFemicidio', 'tipoFemicidio');

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

        


        // Cantidad de femicidios agrupado por localidad y por tipo femicidio(vinculado no vinculado)
        public function femicidiosLocalidad($fechaDesde, $fechaHasta){
            $sql = <<<'SQL'
            SELECT
            localidad.nombre AS descripcion, tipo_femicidio.descripcion AS tipoFemicidio,
            COUNT(DISTINCT detalle_hecho.victima_id) AS cantidad
    
            FROM
            hecho
            INNER JOIN
            localidad
            ON 
            hecho.localidad_id = localidad.id
            INNER JOIN
            detalle_hecho
            ON 
            hecho.id = detalle_hecho.hecho_id
            INNER JOIN
            victima
            ON 
            detalle_hecho.victima_id = victima.id 
            INNER JOIN
            tipo_femicidio
            ON 
		    victima.tipo_femicidio_id = tipo_femicidio.id   
            WHERE hecho.fecha >= :fechaDesde
            AND hecho.fecha <= :fechaHasta
            AND femicidio = 'Si'
            GROUP BY
            localidad.nombre, tipo_femicidio.descripcion
          
    
SQL;
    
                $rsm = new ResultSetMapping();
    
                $rsm->addScalarResult('descripcion', 'descripcion');
                $rsm->addScalarResult('tipoFemicidio', 'tipoFemicidio');

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


// Cantidad de femicidios agrupado por rango etario y por tipo femicidio(vinculado no vinculado)
public function femicidiosRangoEtario($fechaDesde, $fechaHasta){
    $sql = <<<'SQL'
        SELECT
	edad_legal.descripcion AS descripcion, tipo_femicidio.descripcion AS tipoFemicidio,  
	COUNT(DISTINCT detalle_hecho.victima_id) AS cantidad
	 	
    FROM
	hecho
	INNER JOIN
	detalle_hecho
	ON 
		hecho.id = detalle_hecho.hecho_id
	INNER JOIN
	victima
	ON 
		detalle_hecho.victima_id = victima.id
	INNER JOIN
	rango_etario
	ON 
		victima.rango_etario_id = rango_etario.id
	INNER JOIN
	edad_legal
	ON 
		victima.edad_legal_id = edad_legal.id
    INNER JOIN
	tipo_femicidio
	ON 
		victima.tipo_femicidio_id = tipo_femicidio.id
        WHERE hecho.fecha >= :fechaDesde
            AND hecho.fecha <= :fechaHasta
            AND femicidio = 'Si'
            GROUP BY  edad_legal.descripcion, tipo_femicidio.descripcion
          
SQL;

        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('descripcion', 'descripcion');
        $rsm->addScalarResult('tipoFemicidio', 'tipoFemicidio');       
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



// Cantidad de femicidios agrupado por edad legal y por tipo femicidio(vinculado no vinculado)
public function femicidiosEdadLegal($fechaDesde, $fechaHasta){
    $sql = <<<'SQL'
       SELECT
	   rango_etario.descripcion AS descripcion, tipo_femicidio.descripcion AS tipoFemicidio,  
	   COUNT(DISTINCT detalle_hecho.victima_id) AS cantidad
FROM
	hecho
	INNER JOIN
	detalle_hecho
	ON 
		hecho.id = detalle_hecho.hecho_id
	INNER JOIN
	victima
	ON 
		detalle_hecho.victima_id = victima.id
	INNER JOIN
	rango_etario
	ON 
	victima.rango_etario_id = rango_etario.id
    INNER JOIN
	tipo_femicidio
	ON 
		victima.tipo_femicidio_id = tipo_femicidio.id
        WHERE hecho.fecha >= :fechaDesde
            AND hecho.fecha <= :fechaHasta
            AND femicidio = 'Si'
            GROUP BY  rango_etario.descripcion, tipo_femicidio.descripcion
          
SQL;

        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('descripcion', 'descripcion');
        $rsm->addScalarResult('tipoFemicidio', 'tipoFemicidio');
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
        




///// Informe sobre femicidios(contexto femicidio y tipo femicidio, medidas 
///de protección y especificación de las mismas )</h3>  

public function femicidioContexto($fechaDesde, $fechaHasta){
    $sql = <<<'SQL'
    SELECT DISTINCT
	detalle_hecho.pres_autor_id AS presAutorId, 
	detalle_hecho.victima_id AS victimaId, 
	detalle_hecho.hecho_id AS hechoId, 
	cont_femicida.descripcion AS ContextoFemicida, 
	tipo_femicidio.descripcion AS TipoFemicicio, 
    detalle_hecho.den_previa AS denPrevia, 
	detalle_hecho.den_prev_desc AS denPreviaDesc,
	victima.medida_protecc_vigente AS medidaProteccion, 
	victima.medida_protecc_especif AS medidaProteccionEsp,
    hecho.fecha AS fecha
FROM
	hecho
	INNER JOIN
	detalle_hecho
	ON 
		hecho.id = detalle_hecho.hecho_id
	INNER JOIN
	victima
	ON 
		detalle_hecho.victima_id = victima.id
	INNER JOIN
	cont_femicida
	ON 
		victima.cont_femicida_id = cont_femicida.id
	INNER JOIN
	tipo_femicidio
	ON 
		victima.tipo_femicidio_id = tipo_femicidio.id

        WHERE hecho.fecha >= :fechaDesde
        AND hecho.fecha <= :fechaHasta
        AND femicidio = 'Si'
        ORDER BY
        detalle_hecho.victima_id DESC
              

SQL;
        $rsm = new ResultSetMapping();
        
        $rsm->addScalarResult('presAutorId', 'presAutorId');
        $rsm->addScalarResult('victimaId', 'victimaId');
        $rsm->addScalarResult('hechoId', 'hechoId');
        $rsm->addScalarResult('ContextoFemicida', 'ContextoFemicida');
        $rsm->addScalarResult('TipoFemicicio', 'TipoFemicicio');
        $rsm->addScalarResult('denPrevia', 'denPrevia');
        $rsm->addScalarResult('denPreviaDesc', 'denPreviaDesc');
        $rsm->addScalarResult('medidaProteccion', 'medidaProteccion');
        $rsm->addScalarResult('medidaProteccionEsp', 'medidaProteccionEsp');
        $rsm->addScalarResult('fecha', 'fecha');
       
       

        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);

        $fechaDesdeCorregida = clone $fechaDesde;
        $fechaHastaCorregida = clone $fechaHasta;

        $fechaDesdeCorregida->setTime(0, 0, 0);
        $fechaHastaCorregida->add(new \DateInterval('P1D'))->setTime(0, 0, 0);

        $query->setParameter(':fechaDesde', $fechaDesdeCorregida)
            ->setParameter(':fechaHasta', $fechaHastaCorregida);

        return $query->getArrayResult();
}


    ///femicidio por espacio de ocurrencia  

public function femicidioEspacio($fechaDesde, $fechaHasta){
    $sql = <<<'SQL'
    SELECT DISTINCT
	detalle_hecho.pres_autor_id AS presAutorId, 
	detalle_hecho.victima_id AS victimaId, 
	detalle_hecho.hecho_id AS hechoId, 
	zona.descripcion AS ZonaOcurrencia, 
	tipo_espacio.descripcion AS TipoEspOcurrencia,
    lugar.descripcion AS Lugar,	
	hecho.lugar_ocu_otro AS LugarOtro, 
	tipo_lugar.descripcion AS TipoLugarOcurrencia, 
	hecho.acceso_ocu AS TipoAcceso, 
	tipo_dom_particular.descripcion AS domicilio,
    hecho.dom_part_otro AS domicilioOtro,	
    victima.femicidio AS femicidio, 
    tipo_femicidio.descripcion AS tipoFemicidio,
	hecho.fecha AS fecha
	
	
FROM
	hecho
	INNER JOIN
	detalle_hecho
	ON 
		hecho.id = detalle_hecho.hecho_id
	INNER JOIN
	victima
	ON 
		detalle_hecho.victima_id = victima.id
	INNER JOIN
	zona
	ON 
		hecho.zona_ocu_id = zona.id
	INNER JOIN
	tipo_espacio
	ON 
		hecho.tipo_esp_ocu_id = tipo_espacio.id
	INNER JOIN
	tipo_lugar
	ON 
		hecho.tipo_lug_ocu_id = tipo_lugar.id
	INNER JOIN
	lugar
	ON 
		hecho.lugar_ocu_id = lugar.id
	INNER JOIN
	tipo_dom_particular
	ON 
	hecho.dom_part_ocu_id = tipo_dom_particular.id
    INNER JOIN
	tipo_femicidio
	ON 
		victima.tipo_femicidio_id = tipo_femicidio.id

        WHERE hecho.fecha >= :fechaDesde
        AND hecho.fecha <= :fechaHasta
        AND femicidio = 'Si'
                  

SQL;
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('presAutorId', 'presAutorId');
        $rsm->addScalarResult('victimaId', 'victimaId');
        $rsm->addScalarResult('hechoId', 'hechoId');
        $rsm->addScalarResult('ZonaOcurrencia', 'ZonaOcurrencia');
        $rsm->addScalarResult('TipoEspOcurrencia', 'TipoEspOcurrencia');
        $rsm->addScalarResult('Lugar', 'Lugar');
        $rsm->addScalarResult('TipoLugarOcurrencia', 'TipoLugarOcurrencia');
        $rsm->addScalarResult('TipoAcceso', 'TipoAcceso');
        $rsm->addScalarResult('domicilio', 'domicilio');
        $rsm->addScalarResult('domicilioOtro', 'domicilioOtro');
        $rsm->addScalarResult('femicidio', 'femicidio');
        $rsm->addScalarResult('tipoFemicidio', 'tipoFemicidio');

        $rsm->addScalarResult('fecha', 'fecha');
       
       

        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);

        $fechaDesdeCorregida = clone $fechaDesde;
        $fechaHastaCorregida = clone $fechaHasta;

        $fechaDesdeCorregida->setTime(0, 0, 0);
        $fechaHastaCorregida->add(new \DateInterval('P1D'))->setTime(0, 0, 0);

        $query->setParameter(':fechaDesde', $fechaDesdeCorregida)
            ->setParameter(':fechaHasta', $fechaHastaCorregida);

        return $query->getArrayResult();
}



    // Femicidio por mecanismo y arma
    public function victimaFemicidioMecanimo($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
    SELECT
	fecha AS fecha,
    hecho.anio AS anio,
    hecho.mes AS mes,
    hecho.dia_ocu AS dia,
    hecho.gran_rcia AS granRcia,	
	hecho_id AS hechoId, 
    victima.id  AS victimaID,
	victima.femicidio AS femicidio, 
	tipo_femicidio.descripcion AS tipoFemicidio, 
    
	mecanismo_muerte.descripcion AS mecanismoMuerte,
	victima.mecanismo_muerte_otro AS mecanismoMuerteOtro, 
	tipo_arma.descripcion  AS tipoArma,
	victima.tipo_arma_otro AS tipoArmaOtro
	
FROM
	hecho
	INNER JOIN
	detalle_hecho
	ON 
		hecho.id = detalle_hecho.hecho_id
	INNER JOIN
	victima
	ON 
		detalle_hecho.victima_id = victima.id
	INNER JOIN
	tipo_arma
	ON 
		victima.tipo_arma_id = tipo_arma.id
	INNER JOIN
	mecanismo_muerte
	ON 
	victima.mecanismo_muerte_id = mecanismo_muerte.id
    INNER JOIN
	tipo_femicidio
	ON 
	victima.tipo_femicidio_id = tipo_femicidio.id
            WHERE hecho.fecha >= :fechaDesde
            AND hecho.fecha <= :fechaHasta
            HAVING femicidio = 'Si'
            ORDER BY hecho.fecha
                  

SQL;
    $rsm = new ResultSetMapping();
    $rsm->addScalarResult('fecha', 'fecha');
    $rsm->addScalarResult('anio', 'anio');
    $rsm->addScalarResult('mes', 'mes');
    $rsm->addScalarResult('femicidio', 'femicidio');
    $rsm->addScalarResult('tipoFemicidio', 'tipoFemicidio');
   
    $rsm->addScalarResult('dia', 'dia');
    $rsm->addScalarResult('hechoId', 'hechoId');
    $rsm->addScalarResult('victimaID', 'victimaID');
    
    $rsm->addScalarResult('mecanismoMuerte', 'mecanismoMuerte');
    $rsm->addScalarResult('mecanismoMuerteOtro', 'mecanismoMuerteOtro');
    $rsm->addScalarResult('tipoArma', 'tipoArma');
    $rsm->addScalarResult('tipoArmaOtro', 'tipoArmaOtro');
    $rsm->addScalarResult('granRcia', 'granRcia');
    
    
   

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
    //  * @return Victima[] Returns an array of Victima objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Victima
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
