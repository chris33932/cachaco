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


    // Cantidad de victimas por tipo arma
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
	detalle_hecho.pres_autor_id AS presAutor, 
	detalle_hecho.victima_id AS victima, 
	hecho.id AS hecho, 
	sexo.descripcion AS sexo, 
	genero.descripcion AS genero, 
	victima.genero_otro AS genetoOtro,
    victima.edad AS edad, 
	rango_etario.descripcion AS grupoEtario, 
	edad_legal.descripcion AS edadLegal, 
	estado_civil.descripcion AS estado_civil,
	tipo_femicidio.descripcion AS tipoFemicidio, 
	hecho.anio
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
	tipo_femicidio
	ON 
		victima.tipo_femicidio_id = tipo_femicidio.id
	LEFT JOIN
	genero
	ON 
		victima.genero_id = genero.id
	LEFT JOIN
	rango_etario
	ON 
		victima.rango_etario_id = rango_etario.id
	LEFT JOIN
	edad_legal
	ON 
		victima.edad_legal_id = edad_legal.id
	LEFT JOIN
	estado_civil
	ON 
		victima.estado_civil_id = estado_civil.id
            WHERE hecho.fecha >= :fechaDesde
            AND hecho.fecha <= :fechaHasta
            AND femicidio = 'Si'
            ORDER BY detalle_hecho.victima_id DESC
                  

SQL;
    $rsm = new ResultSetMapping();
    $rsm->addScalarResult('presAutor', 'presAutor');
    $rsm->addScalarResult('victima', 'victima');
    $rsm->addScalarResult('hecho', 'hecho');
    $rsm->addScalarResult('sexo', 'sexo');
    $rsm->addScalarResult('genero', 'genero'); 
    $rsm->addScalarResult('genetoOtro', 'genetoOtro');
    $rsm->addScalarResult('edad', 'edad');
    $rsm->addScalarResult('grupoEtario', 'grupoEtario');
    $rsm->addScalarResult('edadLegal', 'edadLegal');

    $rsm->addScalarResult('estado_civil', 'estado_civil');
    $rsm->addScalarResult('tipoFemicidio', 'tipoFemicidio');
    $rsm->addScalarResult('anio', 'anio');
   

      

    $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);

    $fechaDesdeCorregida = clone $fechaDesde;
    $fechaHastaCorregida = clone $fechaHasta;

    $fechaDesdeCorregida->setTime(0, 0, 0);
    $fechaHastaCorregida->add(new \DateInterval('P1D'))->setTime(0, 0, 0);

    $query->setParameter(':fechaDesde', $fechaDesdeCorregida)
        ->setParameter(':fechaHasta', $fechaHastaCorregida);

    return $query->getArrayResult();
}

// DISTRIBUCION DE VICTIMAS DE FEMICIDIO DETALLES CON AUTOR

public function victimasFemVinculo($fechaDesde, $fechaHasta){
    $sql = <<<'SQL'
        SELECT DISTINCT
	detalle_hecho.pres_autor_id AS autor, 
	detalle_hecho.victima_id AS victima, 
	hecho.id AS hecho, 
	detalle_hecho.den_previa AS denPrevia, 
	detalle_hecho.den_prev_desc AS denPreviaDesc, 
	detalle_hecho.vinculo AS vinculo, 
	detalle_hecho.vinculo_familiar AS vinculoFliar, 
	detalle_hecho.vinculo_familiar_otro AS vinculoFliarOtro, 
	detalle_hecho.vinculo_no_familiar AS vinculoNoFliar, 
	detalle_hecho.vinculo_no_familiar_otro AS vinculoNoFliarOtro, 
	detalle_hecho.conviviente AS conviviente, 
	detalle_hecho.uso_arma_fue AS usoArmaFuego, 
	situacion_arma.descripcion AS sitArmaFuego, 
	tipo_femicidio.descripcion AS tipoFemicidio, 
	detalle_hecho.est_intox AS estIntox, 
	detalle_hecho.est_intox_otro AS estIntoxOtro, 
	comp_hecho.descripcion AS compHecho, 
	detalle_hecho.comp_hecho_otro AS compHechoOtro,
	hecho.anio AS anio
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
	situacion_arma
	ON 
		detalle_hecho.sit_arma_fue_id = situacion_arma.id
	LEFT JOIN
	tipo_per_arma
	ON 
		detalle_hecho.per_arma_fue_id = tipo_per_arma.id
	LEFT JOIN
	tipo_femicidio
	ON 
		victima.tipo_femicidio_id = tipo_femicidio.id
	LEFT JOIN
	comp_hecho
	ON 
		detalle_hecho.comp_hecho_id = comp_hecho.id

        WHERE hecho.fecha >= :fechaDesde
        AND hecho.fecha <= :fechaHasta
        AND femicidio= 'Si'
        ORDER BY
        	    detalle_hecho.vinculo
              

SQL;
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('autor', 'autor');
        $rsm->addScalarResult('victima', 'victima');
        $rsm->addScalarResult('hecho', 'hecho');
        $rsm->addScalarResult('denPrevia', 'denPrevia');
        $rsm->addScalarResult('denPreviaDesc', 'denPreviaDesc');
        $rsm->addScalarResult('vinculo', 'vinculo');
        $rsm->addScalarResult('vinculoFliar', 'vinculoFliar');
        $rsm->addScalarResult('vinculoFliarOtro', 'vinculoFliarOtro');
        $rsm->addScalarResult('vinculoNoFliar', 'vinculoNoFliar');
        $rsm->addScalarResult('vinculoNoFliarOtro', 'vinculoNoFliarOtro');
        $rsm->addScalarResult('conviviente', 'conviviente');
        $rsm->addScalarResult('usoArmaFuego', 'usoArmaFuego');
        $rsm->addScalarResult('sitArmaFuego', 'sitArmaFuego');
        $rsm->addScalarResult('tipoFemicidio', 'tipoFemicidio');
        $rsm->addScalarResult('estIntox', 'estIntox');
        $rsm->addScalarResult('estIntoxOtro', 'estIntoxOtro');
        $rsm->addScalarResult('compHecho', 'compHecho');
        $rsm->addScalarResult('compHechoOtro', 'compHechoOtro');

        $rsm->addScalarResult('anio', 'anio');



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
        




///// Informe sobre femicidios(contexto femicidio y tipo femicidio )</h3>  

public function femicidioContexto($fechaDesde, $fechaHasta){
    $sql = <<<'SQL'
 SELECT DISTINCT
	detalle_hecho.pres_autor_id AS presAutor, 
	detalle_hecho.victima_id AS victima, 
	detalle_hecho.hecho_id AS hecho, 
	cont_femicida.descripcion AS contextoFemicida, 
	tipo_femicidio.descripcion AS tipoFemicicio, 
    ocasion_delito.descripcion AS ocasionDelito, 
	hecho.oca_delito_otro AS ocaDelitoOtro,
    hecho.anio AS anio
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
	cont_femicida
	ON 
		victima.cont_femicida_id = cont_femicida.id
    LEFT JOIN
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
        
        $rsm->addScalarResult('presAutor', 'presAutor');
        $rsm->addScalarResult('victima', 'victima');
       
        $rsm->addScalarResult('hecho', 'hecho');
        $rsm->addScalarResult('contextoFemicida', 'contextoFemicida');
        $rsm->addScalarResult('tipoFemicicio', 'tipoFemicicio');
        $rsm->addScalarResult('ocasionDelito', 'ocasionDelito');
        $rsm->addScalarResult('ocaDelitoOtro', 'ocaDelitoOtro');

        $rsm->addScalarResult('anio', 'anio');
       
       

        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);

        $fechaDesdeCorregida = clone $fechaDesde;
        $fechaHastaCorregida = clone $fechaHasta;

        $fechaDesdeCorregida->setTime(0, 0, 0);
        $fechaHastaCorregida->add(new \DateInterval('P1D'))->setTime(0, 0, 0);

        $query->setParameter(':fechaDesde', $fechaDesdeCorregida)
            ->setParameter(':fechaHasta', $fechaHastaCorregida);

        return $query->getArrayResult();
}

///// Informe sobre femicidios(DISTRIBUCIÓN DE FEMICIDIOS POR TIEMPO)</h3>  

public function femicidiosTiempo($fechaDesde, $fechaHasta){
    $sql = <<<'SQL'
 SELECT DISTINCT
	detalle_hecho.pres_autor_id AS presAutor, 
	detalle_hecho.victima_id AS victima, 
	detalle_hecho.hecho_id AS hecho, 
	tipo_femicidio.descripcion AS tipoFemicicio, 
	hecho.fecha AS fecha,
	hecho.anio AS anio, 
	hecho.mes AS mes, 
	hecho.hora_ocu AS hora, 
	hecho.dia_ocu AS dia, 
	hecho.franja_h_seis AS franjaSeis, 
	hecho.franja_h_tres AS franjaTres, 
	hecho.barrio_ocu AS barrio, 
	hecho.calle_ocu AS calle, 
	hecho.altura_ocu AS altura, 
	hecho.intersecc_ocu AS interseccion, 
	hecho.calle_int_ocu AS calleInterseccion, 
	rep_geografica.descripcion AS repGeo,
	hecho.latitud_ocu AS latitud, 
	hecho.longitud_ocu AS longitud
	
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
	tipo_femicidio
	ON 
		victima.tipo_femicidio_id = tipo_femicidio.id
	LEFT JOIN
	rep_geografica
	ON 
	hecho.rep_geo_ocu_id = rep_geografica.id
        WHERE hecho.fecha >= :fechaDesde
        AND hecho.fecha <= :fechaHasta
        AND femicidio = 'Si'
        ORDER BY
        detalle_hecho.victima_id DESC
              

SQL;
        $rsm = new ResultSetMapping();
        
        $rsm->addScalarResult('presAutor', 'presAutor');
        $rsm->addScalarResult('victima', 'victima');
        $rsm->addScalarResult('hecho', 'hecho');
        $rsm->addScalarResult('tipoFemicicio', 'tipoFemicicio');
        $rsm->addScalarResult('fecha', 'fecha');
        $rsm->addScalarResult('anio', 'anio');
        $rsm->addScalarResult('mes', 'mes');
        $rsm->addScalarResult('hora', 'hora');
        $rsm->addScalarResult('dia', 'dia');
        $rsm->addScalarResult('franjaSeis', 'franjaSeis');
        $rsm->addScalarResult('franjaTres', 'franjaTres');
        $rsm->addScalarResult('barrio', 'barrio');
        $rsm->addScalarResult('calle', 'calle');
        $rsm->addScalarResult('altura', 'altura');
        $rsm->addScalarResult('interseccion', 'interseccion');
        $rsm->addScalarResult('calleInterseccion', 'calleInterseccion');
        $rsm->addScalarResult('repGeo', 'repGeo');
        $rsm->addScalarResult('latitud', 'latitud');
        $rsm->addScalarResult('longitud', 'longitud');
       

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
	detalle_hecho.pres_autor_id AS presAutor, 
	detalle_hecho.victima_id AS victima, 
	detalle_hecho.hecho_id AS hecho, 
	departamento.descripcion AS departamento, 
	localidad.nombre AS localidad, 
	hecho.gran_rcia AS granRcia, 
	zona.descripcion AS zonaOcurrencia, 
	tipo_espacio.descripcion AS tipoEspOcurrencia, 
	lugar.descripcion AS lugar, 
	hecho.lugar_ocu_otro AS lugarOtro, 
	tipo_lugar.descripcion AS tipoLugarOcurrencia, 
	hecho.acceso_ocu AS tipoAcceso, 
	tipo_dom_particular.descripcion AS domicilio, 
	hecho.dom_part_otro AS domicilioOtro, 
	tipo_femicidio.descripcion AS tipoFemicidio, 
	hecho.anio AS anio
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
	zona
	ON 
		hecho.zona_ocu_id = zona.id
	LEFT JOIN
	tipo_espacio
	ON 
		hecho.tipo_esp_ocu_id = tipo_espacio.id
	LEFT JOIN
	tipo_lugar
	ON 
		hecho.tipo_lug_ocu_id = tipo_lugar.id
	LEFT JOIN
	lugar
	ON 
		hecho.lugar_ocu_id = lugar.id
	LEFT JOIN
	tipo_dom_particular
	ON 
		hecho.dom_part_ocu_id = tipo_dom_particular.id
	LEFT JOIN
	tipo_femicidio
	ON 
		victima.tipo_femicidio_id = tipo_femicidio.id
	LEFT JOIN
	departamento
	ON 
		hecho.departamento_id = departamento.id
	LEFT JOIN
	localidad
	ON 
		hecho.localidad_id = localidad.id

        WHERE hecho.fecha >= :fechaDesde
        AND hecho.fecha <= :fechaHasta
        AND femicidio = 'Si'
                  

SQL;
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('presAutor', 'presAutor');
        $rsm->addScalarResult('victima', 'victima');
        $rsm->addScalarResult('hecho', 'hecho');
        $rsm->addScalarResult('departamento', 'departamento');
        $rsm->addScalarResult('localidad', 'localidad');
        $rsm->addScalarResult('granRcia', 'granRcia');
        $rsm->addScalarResult('zonaOcurrencia', 'zonaOcurrencia');
        $rsm->addScalarResult('tipoEspOcurrencia', 'tipoEspOcurrencia');
        $rsm->addScalarResult('lugar', 'lugar');
        $rsm->addScalarResult('lugarOtro', 'lugarOtro');
        $rsm->addScalarResult('tipoLugarOcurrencia', 'tipoLugarOcurrencia');
        $rsm->addScalarResult('tipoAcceso', 'tipoAcceso');
        $rsm->addScalarResult('domicilio', 'domicilio');
        $rsm->addScalarResult('domicilioOtro', 'domicilioOtro');
        $rsm->addScalarResult('tipoFemicidio', 'tipoFemicidio');
        $rsm->addScalarResult('anio', 'anio');
       
       

        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);

        $fechaDesdeCorregida = clone $fechaDesde;
        $fechaHastaCorregida = clone $fechaHasta;

        $fechaDesdeCorregida->setTime(0, 0, 0);
        $fechaHastaCorregida->add(new \DateInterval('P1D'))->setTime(0, 0, 0);

        $query->setParameter(':fechaDesde', $fechaDesdeCorregida)
            ->setParameter(':fechaHasta', $fechaHastaCorregida);

        return $query->getArrayResult();
}




    ///femicidio situación socio-económica

public function femicidioSitEco($fechaDesde, $fechaHasta){
    $sql = <<<'SQL'
    SELECT DISTINCT
	detalle_hecho.pres_autor_id AS presAutor, 
	detalle_hecho.victima_id AS victima, 
	detalle_hecho.hecho_id AS hecho, 
	victima.discapacidad AS discapacidad, 
	victima.embarazada AS embarazada, 
	victima.privada_libertad AS privadaLibertad, 
	victima.ejer_prostitucion AS ejerProstitucion, 
	victima.pueblo_originario AS puebloOrig, 
	etnia.descripcion AS etnia, 
	victima.etnia_otro AS etniaOtro, 
	situacion_laboral.descripcion AS sitLaboral, 
	victima.otra_sit_laboral AS otraSitLaboral, 
	condicion_actividad.descripcion AS condActividad, 
	victima.hijos_pers_cargo AS hijoCargo, 
	victima.cant_a_cargo AS cantACargo, 
	victima.benef_ley_brisa AS benefLeyBrisa, 
	victima.cant_benef AS cantBenefLeyBrisa, 
	nivel_instruccion.descripcion AS nivInst, 
	nivel_inst_formal.descripcion AS nifInstFormal,
    tipo_femicidio.descripcion AS tipoFemicidio,
    hecho.anio AS anio
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
	etnia
	ON 
		victima.etnia_id = etnia.id
	LEFT JOIN
	situacion_laboral
	ON 
		victima.sit_laboral_id = situacion_laboral.id
	LEFT JOIN
	condicion_actividad
	ON 
		victima.cond_actividad_id = condicion_actividad.id
	LEFT JOIN
	nivel_instruccion
	ON 
		victima.niv_inst_id = nivel_instruccion.id
	LEFT JOIN
	nivel_inst_formal
	ON 
		victima.niv_inst_form_id = nivel_inst_formal.id
	LEFT JOIN
	tipo_femicidio
	ON 
		victima.tipo_femicidio_id = tipo_femicidio.id

            WHERE hecho.fecha >= :fechaDesde
            AND hecho.fecha <= :fechaHasta
            AND femicidio = 'Si'
            ORDER BY hecho.fecha
                  

SQL;
    $rsm = new ResultSetMapping();
    $rsm->addScalarResult('presAutor', 'presAutor');
    $rsm->addScalarResult('victima', 'victima');
    $rsm->addScalarResult('hecho', 'hecho');
    $rsm->addScalarResult('discapacidad', 'discapacidad');
    $rsm->addScalarResult('embarazada', 'embarazada');
   
    $rsm->addScalarResult('privadaLibertad', 'privadaLibertad');
    $rsm->addScalarResult('ejerProstitucion', 'ejerProstitucion');
    $rsm->addScalarResult('puebloOrig', 'puebloOrig');
    $rsm->addScalarResult('etnia', 'etnia');
    $rsm->addScalarResult('etniaOtro', 'etniaOtro');
    $rsm->addScalarResult('sitLaboral', 'sitLaboral');
    $rsm->addScalarResult('otraSitLaboral', 'otraSitLaboral');
    $rsm->addScalarResult('condActividad', 'condActividad');
    $rsm->addScalarResult('hijoCargo', 'hijoCargo');
    $rsm->addScalarResult('cantACargo', 'cantACargo');
    $rsm->addScalarResult('benefLeyBrisa', 'benefLeyBrisa');
    $rsm->addScalarResult('cantBenefLeyBrisa', 'cantBenefLeyBrisa');
    $rsm->addScalarResult('nivInst', 'nivInst');
    $rsm->addScalarResult('nifInstFormal', 'nifInstFormal');
    $rsm->addScalarResult('tipoFemicidio', 'tipoFemicidio');
    $rsm->addScalarResult('anio', 'anio');
    
    
    $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);

    $fechaDesdeCorregida = clone $fechaDesde;
    $fechaHastaCorregida = clone $fechaHasta;

    $fechaDesdeCorregida->setTime(0, 0, 0);
    $fechaHastaCorregida->add(new \DateInterval('P1D'))->setTime(0, 0, 0);

    $query->setParameter(':fechaDesde', $fechaDesdeCorregida)
        ->setParameter(':fechaHasta', $fechaHastaCorregida);

    return $query->getArrayResult();
}


///// Informe sobre femicidios OTROS</h3>  

public function victimaFemicidioMecanismo($fechaDesde, $fechaHasta){
    $sql = <<<'SQL'
    SELECT DISTINCT
	detalle_hecho.pres_autor_id AS presAutor, 
	detalle_hecho.victima_id AS victima, 
	detalle_hecho.hecho_id AS hecho, 
	tipo_femicidio.descripcion AS tipoFemicidio, 
	mecanismo_muerte.descripcion AS mecanismoMuerte, 
	victima.mecanismo_muerte_otro AS mecanismoMuerteOtro, 
	tipo_arma.descripcion AS tipoArma, 
	victima.tipo_arma_otro AS tipoArmaOtro, 
	victima.fuerza_seg AS fuerzaSeguridad , 
	fuerza_seg_pert.descripcion AS fuerzaDescripcion, 
	victima.otra_fuer_pert AS otraFuerzaDescripcion , 
	estado_policial.descripcion AS estadoPolicial , 
	funcion_mom_hecho.descripcion AS funcionEjercicio, 
	victima.medida_protecc_vigente AS medidaProteccion , 
	victima.medida_protecc_especif AS medidaProteccionEspec, 
	victima.violencia_exc AS overkill , 
	victima.estado_intox AS estadoIntox , 
	estado_intox.descripcion AS estadoIntoxDesc, 
	victima.est_intox_otro AS estadoIntoxOtro , 
	victima.desap_ant_hecho AS desapAntesHecho,
    hecho.anio AS anio
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
	tipo_femicidio
	ON 
		victima.tipo_femicidio_id = tipo_femicidio.id
	LEFT JOIN
	mecanismo_muerte
	ON 
		victima.mecanismo_muerte_id = mecanismo_muerte.id
	LEFT JOIN
	tipo_arma
	ON 
		victima.tipo_arma_id = tipo_arma.id
	LEFT JOIN
	fuerza_seg_pert
	ON 
		victima.fuer_seg_pert_id = fuerza_seg_pert.id
	LEFT JOIN
	estado_policial
	ON 
		victima.est_pol_id = estado_policial.id
	LEFT JOIN
	estado_intox
	ON 
		victima.tipo_est_intox_id = estado_intox.id 
    LEFT JOIN
	funcion_mom_hecho
	ON 
		victima.ejer_funcion_id = funcion_mom_hecho.id 
        WHERE hecho.fecha >= :fechaDesde
        AND hecho.fecha <= :fechaHasta
        AND femicidio = 'Si'
        ORDER BY
        detalle_hecho.victima_id DESC
              

SQL;
        $rsm = new ResultSetMapping();
        
        $rsm->addScalarResult('presAutor', 'presAutor');
        $rsm->addScalarResult('victima', 'victima');
        $rsm->addScalarResult('hecho', 'hecho');
        $rsm->addScalarResult('tipoFemicidio', 'tipoFemicidio');
        $rsm->addScalarResult('mecanismoMuerte', 'mecanismoMuerte');
        $rsm->addScalarResult('mecanismoMuerteOtro', 'mecanismoMuerteOtro');
        $rsm->addScalarResult('tipoArma', 'tipoArma');
        $rsm->addScalarResult('tipoArmaOtro', 'tipoArmaOtro');
        $rsm->addScalarResult('fuerzaSeguridad', 'fuerzaSeguridad');
        $rsm->addScalarResult('fuerzaDescripcion', 'fuerzaDescripcion');
        $rsm->addScalarResult('otraFuerzaDescripcion', 'otraFuerzaDescripcion');
        $rsm->addScalarResult('estadoPolicial', 'estadoPolicial');
        $rsm->addScalarResult('funcionEjercicio', 'funcionEjercicio');
        $rsm->addScalarResult('medidaProteccion', 'medidaProteccion');
        $rsm->addScalarResult('medidaProteccionEspec', 'medidaProteccionEspec');
        $rsm->addScalarResult('overkill', 'overkill');
        $rsm->addScalarResult('estadoIntox', 'estadoIntox');
        $rsm->addScalarResult('estadoIntoxDesc', 'estadoIntoxDesc');
        $rsm->addScalarResult('estadoIntoxOtro', 'estadoIntoxOtro');
        $rsm->addScalarResult('desapAntesHecho', 'desapAntesHecho');
        $rsm->addScalarResult('anio', 'anio');
       

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
