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
                    AND hecho.fecha < :fechaHasta
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
                AND hecho.fecha < :fechaHasta
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
                AND hecho.fecha < :fechaHasta
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
                AND hecho.fecha < :fechaHasta
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
            AND hecho.fecha < :fechaHasta
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
            AND hecho.fecha < :fechaHasta
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
            AND hecho.fecha < :fechaHasta
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


    //información sobre los presuntos autores
    public function presAutorInfoGral($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
  SELECT
	detalle_hecho.pres_autor_id AS presAutorId, 
	detalle_hecho.victima_id AS victimaId, 
	detalle_hecho.hecho_id AS hechoId, 
	hecho.anio AS anio, 
	hecho.fecha AS fecha, 
	pres_autor.nombre AS nombre, 
	pres_autor.apellido AS apellido, 
	pres_autor.documento_nro AS nroDoc, 
	sexo.descripcion AS sexo, 
	genero.descripcion AS genero, 
	pres_autor.genero_otro AS generoOtro, 
	pres_autor.edad AS edad, 
	pres_autor.edad_legal AS edadLegal,
	rango_etario.descripcion AS rangoEtario, 
	provincia.descripcion AS prov, 
	departamento.descripcion AS depto, 
	localidad.nombre AS localidad, 
	pres_autor.barrio AS barrio, 
	pres_autor.calle AS calle, 
	pres_autor.altura AS altura, 
	pres_autor.interseccion AS intersecc, 
	pres_autor.calle_interseccion AS calleIntersecc, 
	rep_geografica.descripcion AS sig, 
	pres_autor.latitud AS latitud, 
	pres_autor.longitud AS longitud, 
	pres_autor.fraccion AS fraccion, 
	pres_autor.radio AS radio, 
	nacionalidad.descripcion AS nacionalidad, 
	pres_autor.nacionalidad_otro AS nacionalidadOtro, 
	estado_civil.descripcion AS estCivil, 
	situacion_laboral.descripcion AS sitLab, 
	pres_autor.otra_sit_lab AS sitLabOtro, 
	condicion_actividad.descripcion AS condAct, 
	nivel_instruccion.descripcion AS nivInst, 
	nivel_inst_formal.descripcion AS nivInstFormal, 
	pres_autor.reincidente AS reincidente, 
	pres_autor.ant_penal_den AS antPenal, 
	pres_autor.especif_ant AS antPenalEspec, 
	pres_autor.fuerza_seg AS fuerzaSeg, 
	fuerza_seg_pert.descripcion AS fuerzaSegPert, 
	pres_autor.otra_fuer_seg_pert AS fuerzaSegPertOtra, 
	estado_policial.descripcion AS estPolicial, 
	pres_autor.ejer_func AS ejerFunc, 
	pres_autor.observacion AS observacion
	
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
	sexo
	ON 
		pres_autor.sexo_id = sexo.id
	LEFT JOIN
	genero
	ON 
		pres_autor.genero_id = genero.id
	LEFT JOIN
	rango_etario
	ON 
		pres_autor.rango_etario_id = rango_etario.id
	INNER JOIN
	provincia
	ON 
		pres_autor.provincia_id = provincia.id
	INNER JOIN
	departamento
	ON 
		pres_autor.departamento_id = departamento.id
	LEFT JOIN
	localidad
	ON 
		pres_autor.localidad_id = localidad.id
	LEFT JOIN
	rep_geografica
	ON 
		pres_autor.rep_geo_id = rep_geografica.id
	LEFT JOIN
	nacionalidad
	ON 
		pres_autor.nacionalidad_id = nacionalidad.id
	LEFT JOIN
	estado_civil
	ON 
		pres_autor.estado_civil_id = estado_civil.id
	LEFT JOIN
	situacion_laboral
	ON 
		pres_autor.sit_lab_id = situacion_laboral.id
	LEFT JOIN
	condicion_actividad
	ON 
		pres_autor.cond_act_id = condicion_actividad.id
	LEFT JOIN
	nivel_instruccion
	ON 
		pres_autor.niv_inst_id = nivel_instruccion.id
	LEFT JOIN
	nivel_inst_formal
	ON 
		pres_autor.niv_inst_formal_id = nivel_inst_formal.id
	LEFT JOIN
	fuerza_seg_pert
	ON 
		pres_autor.fuer_seg_pert_id = fuerza_seg_pert.id
	LEFT JOIN
	estado_policial
	ON 
		pres_autor.est_pol_id = estado_policial.id
  
                WHERE hecho.fecha >= :fechaDesde
                    AND hecho.fecha < :fechaHasta
                    ORDER BY hecho.anio
SQL;

        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('presAutorId', 'presAutorId');
        $rsm->addScalarResult('victimaId', 'victimaId');

        $rsm->addScalarResult('hechoId', 'hechoId');
        $rsm->addScalarResult('anio', 'anio');
        $rsm->addScalarResult('fecha', 'fecha');
        $rsm->addScalarResult('nombre', 'nombre');
        $rsm->addScalarResult('apellido', 'apellido');
        $rsm->addScalarResult('nroDoc', 'nroDoc');
        $rsm->addScalarResult('sexo', 'sexo');
        $rsm->addScalarResult('genero', 'genero');
        $rsm->addScalarResult('generoOtro', 'generoOtro');
        $rsm->addScalarResult('edad', 'edad');
        $rsm->addScalarResult('edadLegal', 'edadLegal');
        $rsm->addScalarResult('rangoEtario', 'rangoEtario');
        $rsm->addScalarResult('prov', 'prov');
        $rsm->addScalarResult('depto', 'depto');
        $rsm->addScalarResult('localidad', 'localidad');
        $rsm->addScalarResult('barrio', 'barrio');
        $rsm->addScalarResult('calle', 'calle');
        $rsm->addScalarResult('altura', 'altura');
        $rsm->addScalarResult('intersecc', 'intersecc');
        $rsm->addScalarResult('calleIntersecc', 'calleIntersecc');
        $rsm->addScalarResult('sig', 'sig');
        $rsm->addScalarResult('latitud', 'latitud');
        $rsm->addScalarResult('longitud', 'longitud');
        $rsm->addScalarResult('fraccion', 'fraccion');
        $rsm->addScalarResult('radio', 'radio');
        $rsm->addScalarResult('nacionalidad', 'nacionalidad');
        $rsm->addScalarResult('nacionalidadOtro', 'nacionalidadOtro');
        $rsm->addScalarResult('estCivil', 'estCivil');
        $rsm->addScalarResult('sitLab', 'sitLab');
        $rsm->addScalarResult('sitLabOtro', 'sitLabOtro');
        $rsm->addScalarResult('condAct', 'condAct');
        $rsm->addScalarResult('nivInst', 'nivInst');
        $rsm->addScalarResult('nivInstFormal', 'nivInstFormal');
        $rsm->addScalarResult('reincidente', 'reincidente');
        $rsm->addScalarResult('antPenal', 'antPenal');
        $rsm->addScalarResult('antPenalEspec', 'antPenalEspec');
        $rsm->addScalarResult('fuerzaSeg', 'fuerzaSeg');
        $rsm->addScalarResult('fuerzaSegPert', 'fuerzaSegPert');
        $rsm->addScalarResult('fuerzaSegPertOtra', 'fuerzaSegPertOtra');
        $rsm->addScalarResult('estPolicial', 'estPolicial');
        $rsm->addScalarResult('ejerFunc', 'ejerFunc');
        $rsm->addScalarResult('observacion', 'observacion');
    

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
