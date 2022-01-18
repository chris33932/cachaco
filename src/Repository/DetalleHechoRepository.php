<?php

namespace App\Repository;
use Doctrine\ORM\Query\ResultSetMapping;
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



    // consulta sobre los detalles dentro de cada hecho

    public function detalleHechoInfoGral($fechaDesde, $fechaHasta){
        $sql = <<<'SQL'
    SELECT
	hecho.id AS hechoId, 
	detalle_hecho.hecho_id AS detalleHechoId, 
	detalle_hecho.victima_id AS victimaId, 
	detalle_hecho.pres_autor_id AS presAutorId, 
	detalle_hecho.den_previa AS denPrevia, 
	detalle_hecho.den_prev_desc AS denPrevDesc, 
	detalle_hecho.vinculo AS vinculo, 
	detalle_hecho.vinculo_familiar AS vincFliar, 
	detalle_hecho.vinculo_familiar_otro AS vincFliarOtro, 
	detalle_hecho.vinculo_no_familiar AS vincNoFliar, 
	detalle_hecho.vinculo_no_familiar_otro AS vincNoFliarOtro, 
	detalle_hecho.conviviente AS conviviente, 
	detalle_hecho.uso_arma_fue AS usoArmaFuego, 
	situacion_arma.descripcion AS situacionArma, 
	tipo_per_arma.descripcion AS permisoArma, 
	detalle_hecho.est_intox AS estIntox, 
    estado_intox.descripcion  AS tipoEstIntox, 
	detalle_hecho.est_intox_otro AS estIntoxOtro, 
	sit_procesal.descripcion AS sitProcesal, 
	comp_hecho.descripcion AS compHecho, 
	detalle_hecho.comp_hecho_otro AS compHechoOtro,
    hecho.anio AS anio,
    hecho.fecha AS fecha,
    hecho.link AS link, 
	hecho.observacion AS observacion
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
	estado_intox
	ON 
		detalle_hecho.tipo_e_intox_id = estado_intox.id
	LEFT JOIN
	sit_procesal
	ON 
		detalle_hecho.sit_procesal_id = sit_procesal.id
	LEFT JOIN
	comp_hecho
	ON 
		detalle_hecho.comp_hecho_id = comp_hecho.id
                WHERE hecho.fecha >= :fechaDesde
                    AND hecho.fecha < :fechaHasta
                    ORDER BY hecho.id
SQL;

        $rsm = new ResultSetMapping();

        $rsm->addScalarResult('hechoId', 'hechoId');
        $rsm->addScalarResult('detalleHechoId', 'detalleHechoId');
        $rsm->addScalarResult('victimaId', 'victimaId');
        $rsm->addScalarResult('presAutorId', 'presAutorId');
        $rsm->addScalarResult('denPrevia', 'denPrevia');
        $rsm->addScalarResult('denPrevDesc', 'denPrevDesc');
        $rsm->addScalarResult('vinculo', 'vinculo');
        $rsm->addScalarResult('vincFliar', 'vincFliar');
        $rsm->addScalarResult('vincFliarOtro', 'vincFliarOtro');
        $rsm->addScalarResult('vincNoFliar', 'vincNoFliar');
        $rsm->addScalarResult('vincNoFliarOtro', 'vincNoFliarOtro');
        $rsm->addScalarResult('conviviente', 'conviviente');
        $rsm->addScalarResult('usoArmaFuego', 'usoArmaFuego');
        $rsm->addScalarResult('situacionArma', 'situacionArma');
        $rsm->addScalarResult('permisoArma', 'permisoArma');
        $rsm->addScalarResult('estIntox', 'estIntox');
        $rsm->addScalarResult('tipoEstIntox', 'tipoEstIntox');
        $rsm->addScalarResult('estIntoxOtro', 'estIntoxOtro');
        $rsm->addScalarResult('sitProcesal', 'sitProcesal');
        $rsm->addScalarResult('compHecho', 'compHecho');
        $rsm->addScalarResult('compHechoOtro', 'compHechoOtro');
        $rsm->addScalarResult('anio', 'anio');
        $rsm->addScalarResult('fecha', 'fecha');
        $rsm->addScalarResult('link', 'link');
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
