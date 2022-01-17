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



    ///// Informe sobre todas las categorias de victimaS</h3>  

public function informeGralVictima($fechaDesde, $fechaHasta){
    $sql = <<<'SQL'
 SELECT 
	DISTINCT 
	detalle_hecho.victima_id AS victimaId, 
	detalle_hecho.hecho_id AS hechoId, 
	hecho.anio AS anio, 
	victima.nombre AS nombre, 
	victima.apellido AS apellido, 
	victima.documento_nro AS NroDoc, 
	sexo.descripcion AS sexo, 
	genero.descripcion AS genero, 
	victima.genero_otro AS generoOtro, 
	victima.edad AS edad, 
	rango_etario.descripcion AS rangoEtario, 
	edad_legal.descripcion AS edadLegal, 
	nacionalidad.descripcion AS nacionalidad, 
	victima.nacionalidad_otra AS nacOtra, 
	estado_civil.descripcion AS estadoCivil, 
	provincia.descripcion AS provincia, 
	departamento.descripcion AS departamento, 
	localidad.nombre AS localidad, 
	victima.barrio AS barrio, 
	victima.calle AS calle, 
	victima.altura AS altura, 
	victima.interseccion AS interseccion, 
	victima.calle_interseccion AS calleInter, 
	rep_geografica.descripcion AS sig, 
	victima.latitud AS latitud, 
	victima.longitud AS longitud, 
	victima.fraccion AS fraccion, 
	victima.radio AS radio, 
	victima.discapacidad AS discapacidad, 
	victima.embarazada AS embarazada, 
	victima.privada_libertad AS privLibertad, 
	victima.ejer_prostitucion AS ejerProstitucion, 
	victima.migrante_internacional AS migranteInternac, 
	victima.migrante_intraprov AS migranteIntraProv, 
	victima.migrante_interprov AS migranteInterProv, 
	victima.pueblo_originario AS puebloOrig, 
	etnia.descripcion AS etnia, 
	victima.etnia_otro AS etniaOtro, 
	victima.hab_nativo_esp AS nativoEsp, 
	victima.homosex_bisex AS homoSexBisex, 
	victima.ref_activista AS refActivista, 
	victima.afro AS afro, 
	victima.otra_sit_intersecc AS otraSitInterseccionalidad, 
	situacion_laboral.descripcion AS sitLaboral, 
	victima.otra_sit_laboral AS sitLabOtra, 
	condicion_actividad.descripcion AS condActividad, 
	victima.hijos_pers_cargo AS hijosACargo, 
	victima.cant_a_cargo AS cantHijosACargo, 
	victima.benef_ley_brisa AS benefLeyBrisa, 
	victima.cant_benef AS cantBenef, 
	nivel_instruccion.descripcion AS nivInst, 
	nivel_inst_formal.descripcion AS nivInstFormal
	
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
	sexo
	ON 
		victima.sexo_id = sexo.id
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
	nacionalidad
	ON 
		victima.nacionalidad_id = nacionalidad.id
	LEFT JOIN
	estado_civil
	ON 
		victima.estado_civil_id = estado_civil.id
	LEFT JOIN
	provincia
	ON 
		victima.provincia_id = provincia.id
	LEFT JOIN
	departamento
	ON 
		victima.departamento_id = departamento.id
	LEFT JOIN
	localidad
	ON 
		victima.localidad_id = localidad.id
	LEFT JOIN
	rep_geografica
	ON 
		victima.rep_geo_id = rep_geografica.id
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
	
        WHERE hecho.fecha >= :fechaDesde
        AND hecho.fecha <= :fechaHasta
        ORDER BY
        detalle_hecho.victima_id 
              

SQL;
        $rsm = new ResultSetMapping();
        
        $rsm->addScalarResult('victimaId', 'victimaId');
        $rsm->addScalarResult('hechoId', 'hechoId');
        $rsm->addScalarResult('anio', 'anio');
        $rsm->addScalarResult('nombre', 'nombre');
        $rsm->addScalarResult('apellido', 'apellido');
        $rsm->addScalarResult('NroDoc', 'NroDoc');
        $rsm->addScalarResult('sexo', 'sexo');
        $rsm->addScalarResult('genero', 'genero');
        $rsm->addScalarResult('generoOtro', 'generoOtro');
        $rsm->addScalarResult('edad', 'edad');
        $rsm->addScalarResult('rangoEtario', 'rangoEtario');
        $rsm->addScalarResult('edadLegal', 'edadLegal');
        $rsm->addScalarResult('nacionalidad', 'nacionalidad');
        $rsm->addScalarResult('nacOtra', 'nacOtra');
        $rsm->addScalarResult('estadoCivil', 'estadoCivil');
        $rsm->addScalarResult('provincia', 'provincia');
        $rsm->addScalarResult('departamento', 'departamento');
        $rsm->addScalarResult('localidad', 'localidad');
        $rsm->addScalarResult('barrio', 'barrio');
        $rsm->addScalarResult('calle', 'calle');
        $rsm->addScalarResult('altura', 'altura');
        $rsm->addScalarResult('interseccion', 'interseccion');
        $rsm->addScalarResult('calleInter', 'calleInter');
        $rsm->addScalarResult('sig', 'sig');
        $rsm->addScalarResult('latitud', 'latitud');
        $rsm->addScalarResult('longitud', 'longitud');
        $rsm->addScalarResult('fraccion', 'fraccion');
        $rsm->addScalarResult('radio', 'radio');
        $rsm->addScalarResult('discapacidad', 'discapacidad');
        $rsm->addScalarResult('embarazada', 'embarazada');
        $rsm->addScalarResult('privLibertad', 'privLibertad');
        $rsm->addScalarResult('ejerProstitucion', 'ejerProstitucion');
        $rsm->addScalarResult('migranteInternac', 'migranteInternac');
        $rsm->addScalarResult('migranteIntraProv', 'migranteIntraProv');
        $rsm->addScalarResult('migranteInterProv', 'migranteInterProv');
        $rsm->addScalarResult('puebloOrig', 'puebloOrig');
        $rsm->addScalarResult('etnia', 'etnia');
        $rsm->addScalarResult('etniaOtro', 'etniaOtro');
        $rsm->addScalarResult('nativoEsp', 'nativoEsp');
        $rsm->addScalarResult('homoSexBisex', 'homoSexBisex');
        $rsm->addScalarResult('refActivista', 'refActivista');
        $rsm->addScalarResult('otraSitInterseccionalidad', 'otraSitInterseccionalidad');
        $rsm->addScalarResult('sitLaboral', 'sitLaboral');
        $rsm->addScalarResult('sitLabOtra', 'sitLabOtra');
        $rsm->addScalarResult('condActividad', 'condActividad');
        $rsm->addScalarResult('hijosACargo', 'hijosACargo');
        $rsm->addScalarResult('cantHijosACargo', 'cantHijosACargo');
        $rsm->addScalarResult('benefLeyBrisa', 'benefLeyBrisa');
        $rsm->addScalarResult('cantBenef', 'cantBenef');
        $rsm->addScalarResult('nivInst', 'nivInst');
        $rsm->addScalarResult('nivInstFormal', 'nivInstFormal');
                

        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);

        $fechaDesdeCorregida = clone $fechaDesde;
        $fechaHastaCorregida = clone $fechaHasta;

        $fechaDesdeCorregida->setTime(0, 0, 0);
        $fechaHastaCorregida->add(new \DateInterval('P1D'))->setTime(0, 0, 0);

        $query->setParameter(':fechaDesde', $fechaDesdeCorregida)
            ->setParameter(':fechaHasta', $fechaHastaCorregida);

        return $query->getArrayResult();
}


    ///// Informe sobre mecanismo de muerte victimas</h3>  

    public function infoMecaVictimas($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
    SELECT 
	DISTINCT 
	detalle_hecho.victima_id AS victimaId, 
	detalle_hecho.hecho_id AS hechoId, 
	hecho.anio AS anio, 
	victima.nombre AS nombre, 
	victima.apellido AS apellido, 
	victima.documento_nro AS NroDoc, 
	mecanismo_muerte.descripcion AS mecanismoMuerte, 
	victima.mecanismo_muerte_otro AS mecaMuerteOtro, 
	tipo_arma.descripcion AS tipoArma, 
	victima.tipo_arma_otro AS tipoArmaOtro, 
	victima.fuerza_seg AS fuerzaSeg, 
	fuerza_seg_pert.descripcion AS fuerzaSegPert, 
	victima.otra_fuer_pert AS fuerzaSegPertOtra, 
	estado_policial.descripcion AS estPolicial, 
	funcion_mom_hecho.descripcion AS funcMomHecho, 
	victima.medida_protecc_vigente AS medidaProteccVigente, 
	victima.medida_protecc_especif AS medidaProteccVigenteEspec, 
	victima.violencia_exc AS overkill, 
	victima.estado_intox AS estIntox, 
	estado_intox.descripcion AS estIntoxDesc, 
	victima.est_intox_otro AS estIntoxOtro, 
	victima.desap_ant_hecho AS desapAntesHecho
	
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
	sexo
	ON 
		victima.sexo_id = sexo.id
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
	nacionalidad
	ON 
		victima.nacionalidad_id = nacionalidad.id
	LEFT JOIN
	estado_civil
	ON 
		victima.estado_civil_id = estado_civil.id
	LEFT JOIN
	provincia
	ON 
		victima.provincia_id = provincia.id
	LEFT JOIN
	departamento
	ON 
		victima.departamento_id = departamento.id
	LEFT JOIN
	localidad
	ON 
		victima.localidad_id = localidad.id
	LEFT JOIN
	rep_geografica
	ON 
		victima.rep_geo_id = rep_geografica.id
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
	funcion_mom_hecho
	ON 
		victima.ejer_funcion_id = funcion_mom_hecho.id
	LEFT JOIN
	estado_intox
	ON 
		victima.tipo_est_intox_id = estado_intox.id 
        WHERE hecho.fecha >= :fechaDesde
        AND hecho.fecha <= :fechaHasta
        ORDER BY
        detalle_hecho.victima_id 
              

SQL;
        $rsm = new ResultSetMapping();
        
        $rsm->addScalarResult('victimaId', 'victimaId');
        $rsm->addScalarResult('hechoId', 'hechoId');
        $rsm->addScalarResult('anio', 'anio');
        $rsm->addScalarResult('nombre', 'nombre');
        $rsm->addScalarResult('apellido', 'apellido');
        $rsm->addScalarResult('NroDoc', 'NroDoc');
        $rsm->addScalarResult('mecanismoMuerte', 'mecanismoMuerte');
        $rsm->addScalarResult('mecaMuerteOtro', 'mecaMuerteOtro');
        $rsm->addScalarResult('tipoArma', 'tipoArma');
        $rsm->addScalarResult('tipoArmaOtro', 'tipoArmaOtro');
        $rsm->addScalarResult('fuerzaSeg', 'fuerzaSeg');
        $rsm->addScalarResult('fuerzaSegPert', 'fuerzaSegPert');
        $rsm->addScalarResult('fuerzaSegPertOtra', 'fuerzaSegPertOtra');
        $rsm->addScalarResult('estPolicial', 'estPolicial');
        $rsm->addScalarResult('funcMomHecho', 'funcMomHecho');
        $rsm->addScalarResult('medidaProteccVigente', 'medidaProteccVigente');
        $rsm->addScalarResult('medidaProteccVigenteEspec', 'medidaProteccVigenteEspec');
        $rsm->addScalarResult('overkill', 'overkill');
        $rsm->addScalarResult('estIntox', 'estIntox');
        $rsm->addScalarResult('estIntoxDesc', 'estIntoxDesc');
        $rsm->addScalarResult('estIntoxOtro', 'estIntoxOtro');
        $rsm->addScalarResult('desapAntesHecho', 'desapAntesHecho');
                    
    
            $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);
    
            $fechaDesdeCorregida = clone $fechaDesde;
            $fechaHastaCorregida = clone $fechaHasta;
    
            $fechaDesdeCorregida->setTime(0, 0, 0);
            $fechaHastaCorregida->add(new \DateInterval('P1D'))->setTime(0, 0, 0);
    
            $query->setParameter(':fechaDesde', $fechaDesdeCorregida)
                ->setParameter(':fechaHasta', $fechaHastaCorregida);
    
            return $query->getArrayResult();
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
    hecho.cant_vic_col AS victimasColateral,
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
        LEFT JOIN
	ocasion_delito
	ON
	hecho.oca_delito_id=ocasion_delito.id

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
        $rsm->addScalarResult('victimasColateral', 'victimasColateral');
        
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
    estado_civil.descripcion AS estadoCivil,
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
    LEFT JOIN
	estado_civil
	ON 
		victima.estado_civil_id = estado_civil.id

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
    $rsm->addScalarResult('estadoCivil', 'estadoCivil');
   
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



///// Informe sobre femicidios(Informe sobre presuntos autores)  

public function femicidiosPresAutorInfo($fechaDesde, $fechaHasta){
    $sql = <<<'SQL'
 SELECT DISTINCT
	detalle_hecho.pres_autor_id AS presAutor, 
	departamento.descripcion AS deptoAutor, 
	localidad.nombre AS locAutor,
  	detalle_hecho.victima_id AS victima,	
	detalle_hecho.hecho_id AS hecho, 
	rango_etario.descripcion AS rangoEtario, 
	pres_autor.edad AS edad, 
	pres_autor.edad_legal AS edadLegal, 
	pres_autor.fuerza_seg AS fuerzaSeguridad, 
	fuerza_seg_pert.descripcion AS fuerzaDescripcion, 
	pres_autor.ejer_func AS funciones, 
	nivel_instruccion.descripcion AS nivelInst, 
	nivel_inst_formal.descripcion AS nivelInstFormal, 
	estado_policial.descripcion AS estadoPolicial, 
	estado_civil.descripcion AS estadoCivil, 
	situacion_laboral.descripcion AS sitLaboral, 
	pres_autor.otra_sit_lab AS otraSitLaboral, 
	tipo_femicidio.descripcion AS tipoFemicidio, 
	hecho.anio AS anio

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
	LEFT JOIN
	fuerza_seg_pert
	ON 
		pres_autor.fuer_seg_pert_id = fuerza_seg_pert.id
	LEFT JOIN
	nivel_instruccion
	ON 
		pres_autor.niv_inst_id = nivel_instruccion.id
	LEFT JOIN
	nivel_inst_formal
	ON 
		pres_autor.niv_inst_formal_id = nivel_inst_formal.id
	LEFT JOIN
	estado_policial
	ON 
		pres_autor.est_pol_id = estado_policial.id
	LEFT JOIN
	estado_civil
	ON 
		pres_autor.estado_civil_id = estado_civil.id
	LEFT JOIN
	situacion_laboral
	ON 
		pres_autor.sit_lab_id = situacion_laboral.id
 
	LEFT JOIN
	departamento
	ON 
		pres_autor.departamento_id = departamento.id
  LEFT JOIN
	localidad
	ON 
		pres_autor.localidad_id = localidad.id
  LEFT JOIN
	victima
	ON 
		detalle_hecho.victima_id = victima.id 
	LEFT JOIN	
	tipo_femicidio
	ON tipo_femicidio.id = victima.tipo_femicidio_id
        WHERE hecho.fecha >= :fechaDesde
        AND hecho.fecha <= :fechaHasta
        AND femicidio = 'Si'
        ORDER BY
        detalle_hecho.victima_id DESC
              

SQL;
        $rsm = new ResultSetMapping();
        
        $rsm->addScalarResult('presAutor', 'presAutor');
        $rsm->addScalarResult('deptoAutor', 'deptoAutor');
        $rsm->addScalarResult('locAutor', 'locAutor');
        $rsm->addScalarResult('victima', 'victima');
        $rsm->addScalarResult('hecho', 'hecho');
        $rsm->addScalarResult('rangoEtario', 'rangoEtario');
        $rsm->addScalarResult('edad', 'edad');
        $rsm->addScalarResult('edadLegal', 'edadLegal');
        $rsm->addScalarResult('fuerzaSeguridad', 'fuerzaSeguridad');
        $rsm->addScalarResult('fuerzaDescripcion', 'fuerzaDescripcion');
        $rsm->addScalarResult('funciones', 'funciones');
        $rsm->addScalarResult('nivelInst', 'nivelInst');
        $rsm->addScalarResult('nivelInstFormal', 'nivelInstFormal');
        $rsm->addScalarResult('estadoPolicial', 'estadoPolicial');
        $rsm->addScalarResult('estadoCivil', 'estadoCivil');
        $rsm->addScalarResult('sitLaboral', 'sitLaboral');
        $rsm->addScalarResult('otraSitLaboral', 'otraSitLaboral');
        $rsm->addScalarResult('anio', 'anio');
        $rsm->addScalarResult('tipoFemicidio', 'tipoFemicidio');
       

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
