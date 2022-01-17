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


    
//información sobre los hechos sin el detalle
    public function hechoInfoGral($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
    SELECT
    hecho.id AS hechoId, 
	detalle_hecho.id AS detalleHechoId, 
	victima.id AS victimaId, 
	pres_autor.id AS presAutorId, 
	hecho.nro_preventivo AS nroPrev, 
	hecho.nro_sumario AS sumario, 
	hecho.nro_exp_jud AS nroExpJud, 
	hecho.juzgado AS juzgado, 
	hecho.fiscalia AS fiscalia, 
	comisaria.nombre AS comisaria, 
	hecho.fecha AS fecha, 
	hecho.anio AS anio, 
	hecho.mes AS mes, 
	hecho.dia_ocu AS dia, 
	provincia.descripcion AS provincia, 
	departamento.descripcion AS depto, 
	localidad.nombre AS localidad, 
	hecho.cod_loc_indec AS codIndec, 
	hecho.gran_rcia AS gRcia, 
	hecho.hora_ocu AS hora, 
	hecho.franja_h_seis AS franjaSeis, 
	hecho.franja_h_tres AS franjaTres, 
	hecho.barrio_ocu AS barrio, 
	hecho.calle_ocu AS calle, 
	hecho.altura_ocu AS altura, 
	hecho.intersecc_ocu AS intersecc, 
	hecho.calle_int_ocu AS calleIntersecc, 
	rep_geografica.descripcion AS sig, 
	hecho.latitud_ocu AS latitud, 
	hecho.longitud_ocu AS longitud, 
	zona.descripcion AS zona, 
	tipo_espacio.descripcion AS tipoEsp, 
	tipo_lugar.descripcion AS tipoLugar, 
	hecho.acceso_ocu AS acceso, 
	lugar.descripcion AS lugar,
	hecho.lugar_ocu_otro AS lugarOtro,	
	tipo_dom_particular.descripcion AS domParticular, 
	hecho.dom_part_otro AS domPartOtro, 
	hecho.fraccion_ocu AS fraccion, 
	hecho.radio_ocu AS radio, 
	hecho.coinc_lug_ocu AS coincLugarHallazgo, 
	ocasion_delito.descripcion AS ocaDelito, 
	hecho.oca_delito_otro AS ocaDelitoOtro, 
	origen_registro.descripcion AS regOrigen, 
	hecho.orig_reg_otro AS regOrigOtro, 
	ent_recep_denuncia.descripcion AS recepDenuncia, 
	hecho.recep_den_otro AS recepDenOtro, 
	tipologia.descripcion AS tipologia, 
	hecho.cant_victimas AS cantVictima, 
	hecho.cant_vic_col AS cantidadVicCol, 
	hecho.cant_pres_autor AS cantPresAutores

FROM
	hecho
	LEFT JOIN
	comisaria
	ON 
		hecho.comisaria_id = comisaria.id
	LEFT JOIN
	provincia
	ON 
		hecho.provincia_id = provincia.id
	LEFT JOIN
	departamento
	ON 
		hecho.departamento_id = departamento.id
	LEFT JOIN
	localidad
	ON 
		hecho.localidad_id = localidad.id
	LEFT JOIN
	rep_geografica
	ON 
		hecho.rep_geo_ocu_id = rep_geografica.id
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
	ocasion_delito
	ON 
		hecho.oca_delito_id = ocasion_delito.id
	LEFT JOIN
	origen_registro
	ON 
		hecho.origen_reg_id = origen_registro.id
	LEFT JOIN
	ent_recep_denuncia
	ON 
		hecho.recep_den_id = ent_recep_denuncia.id
	LEFT JOIN
	tipologia
	ON 
		hecho.tipologia_id = tipologia.id
	INNER JOIN
	victima
	INNER JOIN
	detalle_hecho
	ON 
		hecho.id = detalle_hecho.hecho_id AND
		victima.id = detalle_hecho.victima_id
	INNER JOIN
	pres_autor
	ON 
		detalle_hecho.pres_autor_id = pres_autor.id
                WHERE hecho.fecha >= :fechaDesde
                    AND hecho.fecha < :fechaHasta
                    ORDER BY hechoId
SQL;

        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('hechoId', 'hechoId');
        $rsm->addScalarResult('detalleHechoId', 'detalleHechoId');
        $rsm->addScalarResult('victimaId', 'victimaId');
        $rsm->addScalarResult('presAutorId', 'presAutorId');
        $rsm->addScalarResult('nroPrev', 'nroPrev');
        $rsm->addScalarResult('sumario', 'sumario');
        $rsm->addScalarResult('nroExpJud', 'nroExpJud');
        $rsm->addScalarResult('juzgado', 'juzgado');
        $rsm->addScalarResult('fiscalia', 'fiscalia');
        $rsm->addScalarResult('comisaria', 'comisaria');
        $rsm->addScalarResult('fecha', 'fecha');
        $rsm->addScalarResult('anio', 'anio');
        $rsm->addScalarResult('mes', 'mes');
        $rsm->addScalarResult('dia', 'dia');
        $rsm->addScalarResult('provincia', 'provincia');
        $rsm->addScalarResult('depto', 'depto');
        $rsm->addScalarResult('localidad', 'localidad');
        $rsm->addScalarResult('codIndec', 'codIndec');
        $rsm->addScalarResult('gRcia', 'gRcia');
        $rsm->addScalarResult('hora', 'hora');
        $rsm->addScalarResult('franjaSeis', 'franjaSeis');
        $rsm->addScalarResult('franjaTres', 'franjaTres');
        $rsm->addScalarResult('barrio', 'barrio');
        $rsm->addScalarResult('calle', 'calle');
        $rsm->addScalarResult('altura', 'altura');
        $rsm->addScalarResult('intersecc', 'intersecc');
        $rsm->addScalarResult('calleIntersecc', 'calleIntersecc');
        $rsm->addScalarResult('sig', 'sig');
        $rsm->addScalarResult('latitud', 'latitud');
        $rsm->addScalarResult('longitud', 'longitud');
        $rsm->addScalarResult('zona', 'zona');
        $rsm->addScalarResult('tipoEsp', 'tipoEsp');
        $rsm->addScalarResult('tipoLugar', 'tipoLugar');
        $rsm->addScalarResult('acceso', 'acceso');
        $rsm->addScalarResult('lugar', 'lugar');
        $rsm->addScalarResult('lugarOtro', 'lugarOtro');
        $rsm->addScalarResult('domParticular', 'domParticular');
        $rsm->addScalarResult('domPartOtro', 'domPartOtro');
        $rsm->addScalarResult('fraccion', 'fraccion');
        $rsm->addScalarResult('radio', 'radio');
        $rsm->addScalarResult('coincLugarHallazgo', 'coincLugarHallazgo');
        $rsm->addScalarResult('ocaDelito', 'ocaDelito');
        $rsm->addScalarResult('ocaDelitoOtro', 'ocaDelitoOtro');
        $rsm->addScalarResult('regOrigen', 'regOrigen');
        $rsm->addScalarResult('regOrigOtro', 'regOrigOtro');
        $rsm->addScalarResult('recepDenuncia', 'recepDenuncia');
        $rsm->addScalarResult('recepDenOtro', 'recepDenOtro');
        $rsm->addScalarResult('tipologia', 'tipologia');
        $rsm->addScalarResult('cantVictima', 'cantVictima');
        $rsm->addScalarResult('cantidadVicCol', 'cantidadVicCol');
        $rsm->addScalarResult('cantPresAutores', 'cantPresAutores');
              

        $query = $this->getEntityManager()->createNativeQuery($sql, $rsm);

        $fechaDesdeCorregida = clone $fechaDesde;
        $fechaHastaCorregida = clone $fechaHasta;

        $fechaDesdeCorregida->setTime(0, 0, 0);
        $fechaHastaCorregida->add(new \DateInterval('P1D'))->setTime(0, 0, 0);

        $query->setParameter(':fechaDesde', $fechaDesdeCorregida)
            ->setParameter(':fechaHasta', $fechaHastaCorregida);

        return $query->getArrayResult();
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
                    WHERE hecho.fecha >= :fechaDesde
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
                       WHERE hecho.fecha >= :fechaDesde
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




           public function hechosPorDepartamento($fechaDesde, $fechaHasta){
            $sql = <<<'SQL'
                       SELECT
                       departamento.descripcion AS descripcion,
                        COUNT(hecho.id) AS cantidad
                       FROM hecho 
                       hecho
                       INNER JOIN
                       departamento
                       ON 
                       hecho.departamento_id = departamento.id
                       WHERE hecho.fecha >= :fechaDesde
                           AND hecho.fecha < :fechaHasta
                           GROUP BY
                           departamento.id
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



           public function hechosPorRangoHorarioTres($fechaDesde, $fechaHasta){
            $sql = <<<'SQL'
                       SELECT
                       hecho.franja_h_tres AS descripcion,
                        COUNT(hecho.id) AS cantidad
                       FROM hecho 
                           WHERE hecho.fecha >= :fechaDesde
                           AND hecho.fecha < :fechaHasta
                           GROUP BY
                           hecho.franja_h_tres
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


           public function hechosPorRangoHorarioSeis($fechaDesde, $fechaHasta){
            $sql = <<<'SQL'
                       SELECT
                       hecho.franja_h_seis AS descripcion,
                        COUNT(hecho.id) AS cantidad
                       FROM hecho 
                           WHERE hecho.fecha >= :fechaDesde
                           AND hecho.fecha < :fechaHasta
                           GROUP BY
                           hecho.franja_h_tres
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







           public function hechosPorDia($fechaDesde, $fechaHasta){
            $sql = <<<'SQL'
                   SELECT
                   dia_ocu AS descripcion,
                   COUNT(hecho.id) AS cantidad
                   FROM
                   hecho
                   WHERE hecho.fecha >= :fechaDesde
                   AND hecho.fecha < :fechaHasta
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


        public function hechosPorMes($fechaDesde, $fechaHasta){
            $sql = <<<'SQL'
                    SELECT
	               mes AS descripcion,
	               COUNT(hecho.id) AS cantidad
	
                   FROM
	               hecho
                   WHERE hecho.fecha >= :fechaDesde
                   AND hecho.fecha < :fechaHasta
                   GROUP BY
                   mes
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

        public function hechosEnOcasionOtroDelito($fechaDesde, $fechaHasta){
            $sql = <<<'SQL'
                   SELECT
                   ocasion_delito.descripcion AS descripcion,
                   COUNT(hecho.id) AS cantidad
                   FROM
                   hecho
                   INNER JOIN
	               ocasion_delito
	               ON 
	            	hecho.oca_delito_id = ocasion_delito.id
                   WHERE hecho.fecha >= :fechaDesde
                   AND hecho.fecha < :fechaHasta
                   GROUP BY
                   ocasion_delito.descripcion

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



        //----------------------Hechos espacial ----------------//



        public function hechosZonaOcu($fechaDesde, $fechaHasta){
            $sql = <<<'SQL'
                    SELECT
                    zona.descripcion AS descripcion,
                    COUNT(hecho.id) AS cantidad
                    FROM
	                hecho
                    LEFT JOIN
                    zona
                    ON 
                    hecho.zona_ocu_id = zona.id
			
                    WHERE hecho.fecha >= :fechaDesde
                    AND hecho.fecha < :fechaHasta
                    GROUP BY zona.descripcion

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


        

        public function hechosEspOcu($fechaDesde, $fechaHasta){
            $sql = <<<'SQL'
                    SELECT
                    tipo_espacio.descripcion AS descripcion,
	                COUNT(hecho.id) AS cantidad
                    FROM
                    hecho
                    LEFT JOIN
                    tipo_espacio
                    ON 
		       		hecho.tipo_esp_ocu_id = tipo_espacio.id
			
                    WHERE hecho.fecha >= :fechaDesde
                    AND hecho.fecha < :fechaHasta
                    GROUP BY tipo_espacio.descripcion

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

        public function hechosAccesoOcu($fechaDesde, $fechaHasta){
            $sql = <<<'SQL'
                    SELECT
                    hecho.acceso_ocu AS descripcion,
                    COUNT(hecho.id) AS cantidad
                    FROM
                    hecho
			
                    WHERE hecho.fecha >= :fechaDesde
                    AND hecho.fecha < :fechaHasta
                    GROUP BY hecho.acceso_ocu

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



        public function hechosLugarOcu($fechaDesde, $fechaHasta){
            $sql = <<<'SQL'
                  SELECT
                  lugar.descripcion AS descripcion,
	              COUNT(hecho.id) AS cantidad 
                  FROM
                  hecho
                  LEFT JOIN
                  lugar
                  ON 
                  hecho.lugar_ocu_id = lugar.id
                  WHERE hecho.fecha >= :fechaDesde
                  AND hecho.fecha < :fechaHasta
                  GROUP BY lugar.descripcion
    
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


        public function hechosTipoLugarOcu($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
                  SELECT
                  tipo_lugar.descripcion AS descripcion,
                  COUNT(hecho.id) AS cantidad
	            FROM
                hecho
                LEFT JOIN
                tipo_lugar
                ON 
                hecho.tipo_lug_ocu_id = tipo_lugar.id
			
                    WHERE hecho.fecha >= :fechaDesde
                    AND hecho.fecha < :fechaHasta
                    GROUP BY tipo_lugar.descripcion

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

        public function hechosDomPartOcu($fechaDesde, $fechaHasta){
            $sql = <<<'SQL'
                    SELECT
	                  tipo_dom_particular.descripcion AS descripcion,
	                  COUNT(hecho.id) AS cantidad
                      FROM
                      hecho
                      LEFT JOIN
                      tipo_dom_particular
                      ON 
	                  hecho.dom_part_ocu_id = tipo_dom_particular.id
                
                        WHERE hecho.fecha >= :fechaDesde
                        AND hecho.fecha < :fechaHasta
                        GROUP BY tipo_dom_particular.descripcion 
    
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
