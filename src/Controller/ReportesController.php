<?php

namespace App\Controller;

use PHPExcel;
use Twig\Template;
use App\Form\RangoFechaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

  /**
    * @Route("/reportes", defaults={"_format": "html"}, requirements={"_format": "html|xlsx"})
    * 
    */


class ReportesController extends AbstractController
{
    /**
     * @Route("/", name="reporte_index")
     * @Method("GET")
     */
  
    public function index(): Response
    {
        return $this->render('reportes/index.html.twig');
    }

     /**
     * @Route("/victimas_reportes.{_format}", name="victimas_reportes")
     */
    public function victimasReportesAction(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('victimas_reportes'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->victimasPorDepartamento($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Victimas por departamemto',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'Cantidad',
                    //'Monto',
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/victimas_reportes.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }

    

    //---------------------- víctimas información socio-economica -----------------------//
    //----------------------------------------------------------------------//
    /**
     * @Route("/victima_info_general.{_format}", name="victima_info_general")
     */
    public function informeGeneralVictima(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('victima_info_general'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->informeGralVictima($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        //$datos2 = $em->getRepository('App:Victima')
           //         ->victimasPorExc($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Victimas info personal situación socio-económica',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'victimaId',
                    'hechoId',
                    'nombre',
                    'apellido',
                    'NroDoc',
                    'sexo',
                    'genero',
                    'generoOtro',
                    'edad',
                    'rangoEtario',
                    'edadLegal',
                    'nacionalidad',
                    'nacOtra',
                    'estadoCivil',
                    'provincia',
                    'departamento',
                    'localidad',
                    'barrio',
                    'calle',
                    'altura',
                    'interseccion',
                    'calleInter',
                    'sig',
                    'latitud',
                    'longitud',
                    'fraccion',
                    'radio',
                    'discapacidad',
                    'embarazada',
                    'privLibertad',
                    'ejerProstitucion',
                    'migranteInternac',
                    'migranteIntraProv',
                    'migranteInterProv',
                    'puebloOrig',
                    'etnia',
                    'etniaOtro',
                    'nativoEsp',
                    'homoSexBisex',
                    'refActivista',
                    'otraSitInterseccionalidad',
                    'sitLaboral',
                    'sitLabOtra',
                    'condActividad',
                    'hijosACargo',
                    'cantHijosACargo',
                    'benefLeyBrisa',
                    'cantBenef',
                    'nivInst',
                    'nivInstFormal',
                   
                 
                                       
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/victima_info_general.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    //'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }



     //---------------------- víctimas información sobre mecanismo de muerte-----------------------//
    //--------------------------------------------------------------------------------------------//
    /**
     * @Route("/victima_info_mecanismo.{_format}", name="victima_info_mecanismo")
     */
    public function infoMecaVictima(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('victima_info_mecanismo'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->infoMecaVictimas($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        //$datos2 = $em->getRepository('App:Victima')
           //         ->victimasPorExc($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Victimas info personal situación socio-económica',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'victimaId',
                    'hechoId',
                    'nombre',
                    'apellido',
                    'NroDoc',
                    'mecanismoMuerte',
                    'mecaMuerteOtro',
                    'tipoArma',
                    'tipoArmaOtro',
                    'fuerzaSeg',
                    'fuerzaSegPert',
                    'fuerzaSegPertOtra',
                    'estPolicial',
                    'funcMomHecho',
                    'medidaProteccVigente',
                    'medidaProteccVigenteEspec',
                    'overkill',
                    'estIntox',
                    'estIntoxDesc',
                    'estIntoxOtro',
                    'desapAntesHecho',
               
                   
                 
                                       
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/victima_info_mecanismo.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    //'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }

   
















    //---------------------- víctimas por rango etario -----------------------//
    //----------------------------------------------------------------------//

     /**
     * @Route("/victimas_por_rango_etario", name="victimas_por_rango_etario")
     */
    public function victimasPorRangoEtarioAction(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('victimas_por_rango_etario'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->victimasPorRangoEtario($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Hecho',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'Cantidad',
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/victimas_por_rango_etario.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }

    //---------------------- víctimas por edad legal -----------------------//
    //----------------------------------------------------------------------//

     /**
     * @Route("/victimas_por_edad_legal.{_format}", name="victimas_por_edad_legal")
     */
    public function victimasPorEdadLegalAction(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('victimas_por_edad_legal'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->victimasPorEdadLegal($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Hecho',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'Cantidad',
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/victimas_por_edad_legal.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }



    /**
     * @Route("/victimas_por_localidad", name="victimas_por_localidad")
     */
    public function victimasPorLocalidad(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('victimas_por_localidad'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->victimasPorLocalidad($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Victimas por departamemto',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'Cantidad',
                    //'Monto',
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/victimas_reportes.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }

     //------------------------- VICTIMAS POR SEXO Y GENERO------------------------------//
    //-----------------------------------------------------------------------------------//

    
     /**
     * @Route("/victimas_por_sexo_genero.{_format}", name="victimas_por_sexo_genero")
     */
    public function victimasPorSexoGeneroAction(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('victimas_por_sexo_genero'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->victimasPorSexo($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        $datos2 = $em->getRepository('App:Victima')
                    ->victimasPorGenero($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Victima',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'Cantidad',
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/victimas_por_sexo_genero.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }

    //------------------------- VICTIMAS POR DIA Y MES---------------------------------//
    //-------------------------------------------------------------------------------//

    
     /**
     * @Route("/victimas_por_dia_mes", name="victimas_por_dia_mes")
     */
    public function victimasPorDiaMesAction(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('victimas_por_dia_mes'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Hecho')
                    ->hechosPorDia($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        $datos2 = $em->getRepository('App:Hecho')
                    ->hechosPorMes($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Hecho',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'Cantidad',
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/victimas_por_dia_mes.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }

     //------------------------- VICTIMAS POR MECANISMO DE MUERTE Y ARMAS------------------------------//
    //------------------------------------------------------------------------------------//

    
     /**
     * @Route("/victimas_por_mecanismo", name="victimas_por_mecanismo")
     */
    public function victimasPorMecanismoAction(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('victimas_por_mecanismo'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->victimasPorMecanismo($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        $datos1 = $em->getRepository('App:Victima')
                    ->victimasPorTipoArma($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Hecho',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'Cantidad',
                    
                ),
                'datos' => $datos,
                'datos1' => $datos1,

                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/victimas_por_mecanismo.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                'datos1' => $datos1,

                    'formFechas' => $formFechas->createView()
            ));
        }
    }


    //------------------------- VICTIMAS POR CLASE------------------------------//
    //------------------------------------------------------------------------------------//

    
     /**
     * @Route("/victimas_por_clase", name="victimas_por_clase")
     */
    public function victimasPorClaseAction(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('victimas_por_clase'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->victimasPorClase($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Hecho',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'Cantidad',
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/victimas_por_clase.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }





    //------------------------- HECHOS POR TIPOLOGIA------------------------------//
    //----------------------------------------------------------------------------//

    
     /**
     * @Route("/hechos_por_tipologia", name="hechos_por_tipologia")
     */
    public function hechosPorTipologiaAction(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('hechos_por_tipologia'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Hecho')
                    ->hechosPorTipologia($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Hecho',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'Cantidad',
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/hechos_por_tipologia.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }

    //---------------------- hechos por localidad -----------------------//
    //-------------------------------------------------------------------//

     /**
     * @Route("/hechos_por_localidad", name="hechos_por_localidad")
     */
    public function hechosPorLocalidadAction(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('hechos_por_localidad'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Hecho')
                    ->hechosPorLodalidad($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Hecho',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'Cantidad',
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/hechos_por_localidad.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }


    //---------------------- hechos por departamento -----------------------//
    //----------------------------------------------------------------------//

     /**
     * @Route("/hechos_por_departamento", name="hechos_por_departamento")
     */
    public function hechosPorDepartamentoAction(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('hechos_por_departamento'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Hecho')
                    ->hechosPorDepartamento($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Hecho',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'Cantidad',
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/hechos_por_departamento.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }

    //------------------------- HECHOS POR RANGO HORARIO------------------------------//
    //-------------------------------------------------------------------------------//

    
     /**
     * @Route("/hechos_por_rango_horario_tres", name="hechos_por_rango_horario_tres")
     */
    public function hechosPorRangoHorarioAction(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('hechos_por_rango_horario_tres'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Hecho')
                    ->hechosPorRangoHorarioTres($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        $datos2 = $em->getRepository('App:Hecho')
                    ->hechosPorRangoHorarioSeis($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Hecho',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'Cantidad',
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/hechos_por_rango_horario_tres.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }

     //------------------------- HECHOS POR DIA Y MES------------------------------//
    //-------------------------------------------------------------------------------//

    
     /**
     * @Route("/hechos_por_dia_mes", name="hechos_por_dia_mes")
     */
    public function hechosPorDiaMesAction(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('hechos_por_dia_mes'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Hecho')
                    ->hechosPorDia($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        $datos2 = $em->getRepository('App:Hecho')
                    ->hechosPorMes($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Hecho',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'Cantidad',
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/hechos_por_dia_mes.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }

    //------------------------- HECHOS EN OCASION OTRO DELITO------------------------------//
    //------------------------------------------------------------------------------------//

    
     /**
     * @Route("/hechos_en_ocasion_otro_delito", name="hechos_en_ocasion_otro_delito")
     */
    public function hechosEnOcasionOtroDelitoAction(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('hechos_en_ocasion_otro_delito'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Hecho')
                    ->hechosEnOcasionOtroDelito($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Hecho',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'Cantidad',
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/hechos_en_ocasion_otro_delito.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }




    //------------------------- HECHOS POR ESPACIO------------------------------//
    //-------------------------------------------------------------------------------//

    
     /**
     * @Route("/hechos_espacial", name="hechos_espacial")
     */
    public function hechosEspacialAction(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('hechos_espacial'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Hecho')
                    ->hechosZonaOcu($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        $datos2 = $em->getRepository('App:Hecho')
                    ->hechosEspOcu($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

                   
        $datos3 = $em->getRepository('App:Hecho')
                    ->hechosAccesoOcu($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        $datos4 = $em->getRepository('App:Hecho')
                    ->hechosLugarOcu($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        $datos5 = $em->getRepository('App:Hecho')
                    ->hechosTipoLugarOcu($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

                   
        $datos6 = $em->getRepository('App:Hecho')
                    ->hechosDomPartOcu($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Hecho',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'Cantidad',
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/hechos_espacial.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'datos2' => $datos2,
                    'datos3' => $datos3,
                    'datos4' => $datos4,
                    'datos5' => $datos5,               
                    'datos6' => $datos6,

                    'formFechas' => $formFechas->createView()
            ));
        }
    }





    //---------------------- Femicidio por depto y localidad -----------------------//
    //----------------------------------------------------------------------//

     /**
     * @Route("/femicidio_depto_loc", name="femicidio_depto_loc")
     */
    public function femicidioDeptoLocAction(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('femicidio_depto_loc'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->femicidiosDepartamento($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
        
        $datos2 = $em->getRepository('App:Victima')
                    ->femicidiosLocalidad($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Hecho',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'Cantidad',
                    'tipoFemicidio',
                    
                ),
                'datos' => $datos,
                'datos2' => $datos2,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/femicidio_depto_loc.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }

    //---------------------- Femicidio por rango etario y edad legal----------------------//
    //----------------------------------------------------------------------//

     /**
     * @Route("/femicidio_r_etario_e_legal", name="femicidio_r_etario_e_legal")
     */
    public function femicidioRangoEtarioEdadLegalAction(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('femicidio_r_etario_e_legal'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->femicidiosRangoEtario($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
        
        $datos2 = $em->getRepository('App:Victima')
                    ->femicidiosEdadLegal($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Informe sobre femicidios(Genero, generoOtro, edad, edad legal, estado civil)',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'tipoFemicidio',
                    'Cantidad',
                    
                ),
                'datos' => $datos,
                'datos2' => $datos2,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/femicidio_r_etario_e_legal.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }




     //------------------------- FEMICIDIOS Información personal ------------------------------//
    //-------------------------------------------------------------------------------------------//

     /**
     * @Route("/femicidios.{_format}", name="femicidios")
     */
    public function victimasPorExc(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('femicidios'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->victimasPorExc($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        //$datos2 = $em->getRepository('App:Victima')
           //         ->victimasPorExc($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Femicidio - Informe sobre (Género/Rango etario/ Edad legal)',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'presAutor',
                    'victima',
                    'hecho',
                    'sexo',
                    'genero',
                    'genetoOtro',
                    'edad',
                    'grupoEtario',
                    'edadLegal',
                    'estado_civil',
                    'tipoFemicidio',
                    'anio',
                                       
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/femicidioReportes.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    //'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }

    // DISTRIBUCION DE VICTIMAS DE FEMICIDIO DETALLES CON AUTOR
    
     /**
     * @Route("/femicidio_vinc_autor.{_format}", name="femicidio_vinc_autor")
     */
    public function victimasFemicidiosVinculoAutor(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('femicidio_vinc_autor'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->victimasFemVinculo($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        //$datos2 = $em->getRepository('App:Victima')
           //         ->victimasPorExc($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Femicidio - Informe sobre (Vinculo/Denuncias previas/Convivencia/Uso de Arma/Ext intox autor/Comp autor hecho)',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'autor',
                    'victima',
                    'hecho',
                    'denPrevia',
                    'denPreviaDesc',
                    'vinculo',
                    'vinculoFliar',
                    'vinculoFliarOtro',
                    'vinculoNoFliar',
                    'vinculoNoFliarOtro',
                    'conviviente',
                    'usoArmaFuego',
                    'sitArmaFuego',
                    'tipoFemicidio',
                    'estIntox',
                    'estIntoxOtro',
                    'compHecho',
                    'compHechoOtro',
                    'anio',
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/femicidio_vinc_autor.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    //'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }




    // FEMICIDIO DETALLES SOBRE PRESUNTO AUTOR
    
     /**
     * @Route("/femicidio_pres_autor.{_format}", name="femicidio_pres_autor")
     */
    public function femicidiosPresAutorInformacion(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('femicidio_pres_autor'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->femicidiosPresAutorInfo($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    


        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Informe sobre femicidios(contexto femicidio y tipo femicidio )',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'presAutor',
                    'deptoAutor',
                    'locAutor',
                    'victima',
                    'hecho',
                    'rangoEtario',
                    'edad',
                    'edadLegal',
                    'fuerzaSeguridad',
                    'fuerzaDescripcion',
                    'funciones',
                    'nivelInst',
                    'nivelInstFormal',
                    'estadoPolicial',
                    'estadoCivil',
                    'sitLaboral',
                    'otraSitLaboral',
                    'tipoFemicidio',
                    'anio',
                   
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/femicidio_pres_autor.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    //'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }




     //------------------------- FEMICIDIOS contexto femicidio y tipo femicidi  --------------//
    //-------------------------------------------------------------------------------------------//

     /**
     * @Route("/femicidio_contexto.{_format}", name="femicidio_contexto")
     */
    public function femicidioContextoTipo(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('femicidio_contexto'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->femicidioContexto($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        //$datos2 = $em->getRepository('App:Victima')
           //         ->victimasPorExc($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Victima de femicidio',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'presAutorId',
                    'victimaId',
                    'hechoId',
                    'ContextoFemicida',
                    'TipoFemicicio',
                    'ocasionDelito',
                    'ocaDelitoOtro',
                    'victimasColateral',
                    'anio',
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/femicidio_contexto.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    //'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }



    //------------------------- FEMICIDIOS DISTRIBUCIÓN POR TIEMPO  --------------//
    //-------------------------------------------------------------------------------------------//

     /**
     * @Route("/femicidio_tiempo.{_format}", name="femicidio_tiempo")
     */
    public function femicidioDistTiempo(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('femicidio_tiempo'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->femicidiosTiempo($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        //$datos2 = $em->getRepository('App:Victima')
           //         ->victimasPorExc($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Victimas de femicidio distribución temporal',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'presAutor',
                    'victima',
                    'hecho',
                    'tipoFemicicio',
                    'fecha',
                    'anio',
                    'mes',
                    'hora',
                    'dia',
                    'franjaSeis',
                    'franjaTres',
                    'barrio',
                    'calle',
                    'altura',
                    'interseccion',
                    'calleInterseccion',
                    'repGeo',
                    'latitud',
                    'longitud',
                  

                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/femicidio_tiempo.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    //'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }

     //------------------------- FEMICIDIOS variables socio-economicas --------------//
    //-------------------------------------------------------------------------------------------//

     /**
     * @Route("/femicidio_sit_socio.{_format}", name="femicidio_sit_socio")
     */
    public function femicidioSitSocioEco(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('femicidio_sit_socio'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->femicidioSitEco($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Victima de femicidio - situación socio-económica',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'presAutor',
                    'victima',
                    'hecho',
                    'discapacidad',
                    'embarazada',
                    'estadoCivil',
                    'privadaLibertad',
                    'ejerProstitucion',
                    'puebloOrig',
                    'etnia',
                    'etniaOtro',
                    'sitLaboral',
                    'otraSitLaboral',
                    'condActividad',
                    'hijoCargo',
                    'cantACargo',
                    'benefLeyBrisa',
                    'cantBenefLeyBrisa',
                    'nivInst',
                    'nifInstFormal',
                    'tipoFemicidio',
                    'anio',
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/femicidio_sit_socio.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    //'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }








     //------------------------- FEMICIDIOS femicidio espacio ocurrencia  ------------------------------//
    //-------------------------------------------------------------------------------------------//

     /**
     * @Route("/femicidio_espacio.{_format}", name="femicidio_espacio")
     */
    public function femicidioEspacioOcurrencia(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('femicidio_espacio'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->femicidioEspacio($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
        

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Victima de femicidio por espacio de ocurrencia',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'presAutor',
                    'victima',
                    'hecho',
                    'departamento',
                    'localidad', 
                    'granRcia', 
                    'zonaOcurrencia', 
                    'tipoEspOcurrencia', 
                    'lugar', 
                    'lugarOtro',
                    'tipoLugarOcurrencia',
                    'tipoAcceso',
                    'domicilio',
                    'domicilioOtro',
                    'tipoFemicidio',
                    'anio',

                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/femicidio_espacio.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    //'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }



     //------------------------- INFORMACION DE VICTIMAS Y VINCULOS CON AUTORES------------------------------//
    //-------------------------------------------------------------------------------------------//

      /**
     * @Route("/vinculos_reportes", name="vinculos_reportes")
     */
    public function victimasPorVinculo(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('vinculos_reportes'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->victimasPorVinculo($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
    

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Victima',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'hecho',
                    'victima',
                    'autor',
                    'victima',
                    'vinculo',
                    'vinculofliar',
                    'vinculofliarotro',
                    'vinculonofliar',
                    'vinculonofliarotro',
                    'fecha',

                   
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/vinculos_reportes.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                  
                    'formFechas' => $formFechas->createView()
            ));
        }
    }





     /**
     * @Route("/femicidio_mecanismo.{_format}", name="femicidio_mecanismo")
     */
    public function femicidioArmaMecanimos(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('femicidio_mecanismo'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->victimaFemicidioMecanismo($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        //$datos2 = $em->getRepository('App:Victima')
           //         ->victimasPorExc($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Informe sobre femicidios(Mecanimos de muerte/Tipo de arma/Fuerza de Seguridad)',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'PresAutor',
                    'victima',
                    'hecho',
                    'tipoFemicidio',
                    'mecanismoMuerte',
                    'mecanismoMuerteOtro',
                    'tipoArma',
                    'tipoArmaOtro',
                    'fuerzaSeguridad',
                    'fuerzaDescripcion',
                    'otraFuerzaDescripcion',
                    'estadoPolicial',
                    'funcionEjercicio',
                    'medidaProteccion',
                    'medidaProteccionEspec',
                    'overkill',
                    'estadoIntox',
                    'estadoIntoxDesc',
                    'estadoIntoxOtro',
                    'desapAntesHecho',
                    'anio',

                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/femicidio_mecanismo.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    //'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }







    







     //------------------------- PRESUNTOS AUTORES POR SEXO Y GENERO------------------------------//
    //-------------------------------------------------------------------------------------------//

    
     /**
     * @Route("/pres_autor_por_sexo_genero", name="pres_autor_por_sexo_genero")
     */
    public function presAutorPorSexoGeneroAction(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('pres_autor_por_sexo_genero'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:PresAutor')
                    ->presAutorPorSexo($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        $datos2 = $em->getRepository('App:PresAutor')
                    ->presAutorPorGenero($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'PresAutor',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'Cantidad',
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/pres_autor_por_sexo_genero.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }





    
     //------------------------- PRESUNTOS AUTORES POR DEPTO Y LOC------------------------------//
    //-------------------------------------------------------------------------------------------//

    
     /**
     * @Route("/autores_por_departamento_localidad", name="autores_por_departamento_localidad")
     */
    public function presAutorPorDeptoLocAction(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('autores_por_departamento_localidad'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:PresAutor')
                    ->presAutorPorDepartamento($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        $datos2 = $em->getRepository('App:PresAutor')
                    ->presAutorPorLocalidad($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'PresAutor',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'Cantidad',
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/autores_por_departamento_localidad.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }




     //------------------------- PRESUNTOS AUTORES POR DEPTO Y LOC------------------------------//
    //-------------------------------------------------------------------------------------------//

    
     /**
     * @Route("/autores_por_rango_etario_edad_legal", name="autores_por_rango_etario_edad_legal")
     */
    public function presAutorPorRangoEdadAction(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('autores_por_rango_etario_edad_legal'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:PresAutor')
                    ->presAutorPorRango($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        $datos2 = $em->getRepository('App:PresAutor')
                    ->presAutorPorEdadLegal($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'PresAutor',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'Descripcion',
                    'Cantidad',
                    
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/autores_por_rango_etario_edad_legal.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }










     //------------------------- Hechos Información general ------------------------------//
    //-------------------------------------------------------------------------------------------//

     /**
     * @Route("/hecho_info.{_format}", name="hecho_info")
     */
    public function hechoInfoGeneral(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('hecho_info'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Hecho')
                    ->hechoInfoGral($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        //$datos2 = $em->getRepository('App:Victima')
           //         ->victimasPorExc($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Hechos info gral.',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'hechoId',
                    'detalleHechoId',
                    'victimaId',
                    'presAutorId',
                    'nroPrev',
                    'sumario',
                    'nroExpJud',
                    'juzgado',
                    'fiscalia',
                    'comisaria',
                    'fecha',
                    'anio',
                    'mes',
                    'dia',
                    'provincia',
                    'depto',
                    'localidad',
                    'codIndec',
                    'gRcia',
                    'hora',
                    'franjaSeis',
                    'franjaTres',
                    'barrio',
                    'calle',
                    'altura',
                    'intersecc',
                    'calleIntersecc',
                    'sig',
                    'latitud',
                    'longitud',
                    'zona',
                    'tipoEsp',
                    'tipoLugar',
                    'acceso',
                    'lugar',
                    'lugarOtro',
                    'domParticular',
                    'domParticular',
                    'fraccion',
                    'radio',
                    'coincLugarHallazgo',
                    'ocaDelito',
                    'ocaDelitoOtro',
                    'regOrigen',
                    'regOrigOtro',
                    'recepDenuncia',
                    'recepDenOtro',
                    'tipologia',
                    'cantVictima',
                    'cantidadVicCol',
                    'cantPresAutores',

                                       
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/hecho_info.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    //'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }



         //------------------------- DETALLE DE LOS Hechos Información general ------------------------------//
    //-------------------------------------------------------------------------------------------//

     /**
     * @Route("/detalle_hecho_info.{_format}", name="detalle_hecho_info")
     */
    public function detalleHechoInfoGeneral(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('detalle_hecho_info'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:DetalleHecho')
                    ->detalleHechoInfoGral($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        //$datos2 = $em->getRepository('App:Victima')
           //         ->victimasPorExc($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Detalle de los Hechos info gral.',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'hechoId',
                    'detalleHechoId',
                    'victimaId',
                    'presAutorId',
                    'denPrevia',
                    'denPrevDesc',
                    'vinculo',
                    'vincFliar',
                    'vincFliarOtro',
                    'vincNoFliar',
                    'vincNoFliarOtro',
                    'conviviente',
                    'usoArmaFuego',
                    'situacionArma',
                    'permisoArma',
                    'estIntox',
                    'tipoEstIntox',
                    'estIntoxOtro',
                    'sitProcesal',
                    'compHecho',
                    'compHechoOtro',
                    'anio',
                    'fecha',


                                       
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/detalle_hecho_info.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    //'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }


    //------------------------- consulta sobre autores Información general ------------------------------//
    //-------------------------------------------------------------------------------------------//

     /**
     * @Route("/pres_autor_info.{_format}", name="pres_autor_info")
     */
    public function presAutoresInfo(Request $request)
    {

        $rangoFecha = array(
            'fechaDesde' => (new \DateTime())->sub(new \DateInterval('P1M')),
            'fechaHasta' => new \DateTime(),
        );

        $formFechas = $this->createForm(RangoFechaType::class, $rangoFecha, array(
            'action' => $this->generateUrl('pres_autor_info'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:PresAutor')
                    ->presAutorInfoGral($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        //$datos2 = $em->getRepository('App:Victima')
           //         ->victimasPorExc($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

        if ($request->getRequestFormat() == 'xlsx') {
            $datosExcel = array(
                'encabezado' => array(
                    'titulo' => 'Pres Autores info general.',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'hechoId',
                    'presAutorId',
                    'victimaId',
                    'anio',
                    'fecha',
                    'nombre',
                    'apellido',
                    'nroDoc',
                    'sexo',
                    'genero',
                    'generoOtro',
                    'edad',
                    'edadLegal',
                    'rangoEtario',
                    'prov',
                    'depto',
                    'localidad',
                    'barrio',
                    'calle',
                    'altura',
                    'intersecc',
                    'calleIntersecc',
                    'sig',
                    'latitud',
                    'longitud',
                    'fraccion',
                    'radio',
                    'nacionalidad',
                    'nacionalidadOtro',
                    'estCivil',
                    'sitLab',
                    'sitLabOtro',
                    'condAct',
                    'nivInst',
                    'nivInstFormal',
                    'reincidente',
                    'antPenal',
                    'antPenalEspec',
                    'fuerzaSeg',
                    'fuerzaSegPert',
                    'fuerzaSegPertOtra',
                    'estPolicial',
                    'ejerFunc',
                    'observacion',
                    


                                       
                ),
                'datos' => $datos,
                'totales' => array(
                    // 'total 1', 'total 2', 'total 3',
                ),
            );

            return $this->renderExcel($datosExcel);
        } else {
            return $this->render(
                'reportes/pres_autor_info.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    //'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }




























         /////////////////////////////////////////////////
        // -----------------EXCEL --------------------//
        ////////////////////////////////////////////////

private function renderExcel($datos)
{
    $excel = new \PHPExcel();
    $excel->setActiveSheetIndex(0);
    $this->ponerPropiedades($excel, $datos['encabezado']['titulo']);
    $this->generarEncabezadoExcel($excel, $datos['encabezado']);
    $this->generarEncabezadoColumnas($excel, $datos['columnas']);
    $this->generarDatos($excel, $datos['datos']);
    $this->generarTotales($excel, $datos['totales']);
    $this->formatearExcel($excel, $datos['encabezado']['titulo']);
    $response = $this->generarExcelResponse($excel);

    return $response->send();
}

private function ponerPropiedades($excel, $titulo)
{
    $excel->getProperties()
            ->setCreator('Sistema centro de delitos')
            ->setLastModifiedBy('Sistema')
            ->setTitle($titulo)
            ->setSubject('')
            ->setDescription('')
            ->setKeywords('')
            ->setCategory('');
}

private function generarEncabezadoExcel($excel, $encabezado)
{
    $excel->getActiveSheet()
            ->setCellValue('A1', $encabezado['titulo']);

    $columna = 0;
    foreach ($encabezado['filtro'] as $filtro => $valor) {
        $excel->getActiveSheet()->setCellValueByColumnAndRow($columna++, 3, $filtro.': '.$valor);
    }
}

private function generarEncabezadoColumnas($excel, $encabezadoColumnas, $fila = 5)
{
    $columna = 0;
    foreach ($encabezadoColumnas as $titulo) {
        $excel->getActiveSheet()->setCellValueByColumnAndRow($columna++, $fila, $titulo);
    }
    $rango = 'A'.$fila.':'.chr(65 + --$columna).$fila;

    
    $excel->getActiveSheet()
            ->setSharedStyle(
                $this->estiloTituloColumnas(),
                $rango
             );
}

private function generarDatos($excel, $datos)
{
    $fila = 6;
    foreach ($datos as $filas) {
        $columna = 0;
        foreach ($filas as $valor) {
            $excel->getActiveSheet()->setCellValueByColumnAndRow($columna++, $fila, $valor);
        }
        ++$fila;
    }
}

private function generarTotales($excel, $totales)
{
    $fila = 2 + $excel->getActiveSheet()->getHighestRow();
    $columna = 0;
    foreach ($totales as $total) {
        $excel->getActiveSheet()->setCellValueByColumnAndRow($columna++, $fila, $total);
    }
}

private function formatearExcel($excel, $titulo)
{
    $ultimaColumna = $excel->getActiveSheet()->getHighestColumn();
    $excel->getActiveSheet()->mergeCells('A1:'.$ultimaColumna.'1');

    $estiloTitulo = $this->estiloTitulo();
    $excel->getActiveSheet()->setSharedStyle($estiloTitulo, 'A1:'.$ultimaColumna.'1');

    $excel->getActiveSheet()->setTitle(substr($titulo, 0, 30));

    for ($i = 'A'; $i <= $ultimaColumna; ++$i)
    {
        $excel->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
    }

}

private function generarExcelResponse($excel)
{
    $nombre = str_replace(' ', '_', $excel->getActiveSheet()->getTitle()).'_'.(new \DateTime())->format('YmdHisz').'.xlsx';
    $response = new StreamedResponse();
    $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $response->headers->set('Content-Disposition', 'attachment;filename="'.$nombre.'"');
    $response->headers->set('Cache-Control', 'max-age=0');
    $objWriter = \PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $response->setCallback(function () use ($objWriter) {
        $objWriter->save('php://output');
    });

    return $response;
}

private function estiloTitulo()
{
    return (new \PHPExcel_Style)->applyFromArray(array(
        'font' => array(
            'name' => 'Verdana',
            'bold' => true,
            'italic' => false,
            'strike' => false,
            'size' => 16,
            'color' => array(
                'rgb' => 'FFFFFF',
            ),
        ),
        'fill' => array(
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array(
                'argb' => 'FF48D1CC',
            ),
        ),
        'borders' => array(
            'allborders' => array(
                'style' => \PHPExcel_Style_Border::BORDER_THIN,
            ),
        ),
        'alignment' => array(
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'rotation' => 0,
            'wrap' => true,
        ),
    )
    );
}

private function estiloTituloColumnas()
{
    return (new \PHPExcel_Style())->applyFromArray(array(
        'font' => array(
            'name' => 'Arial',
            'bold' => true,
            'color' => array(
                'rgb' => '000000',
            ),
        ),
        'fill' => array(
            'type' => \PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
            'rotation' => 90,
            'startcolor' => array(
                'rgb' => 'CCFFE5',
            ),
            'endcolor' => array(
                'argb' => 'CCFFE5',
            ),
        ),
        'borders' => array(
            'top' => array(
                'style' => \PHPExcel_Style_Border::BORDER_HAIR,
                'color' => array(
                    'rgb' => '143860',
                ),
            ),
            'bottom' => array(
                'style' => \PHPExcel_Style_Border::BORDER_HAIR,
                'color' => array(
                    'rgb' => '143860',
                ),
            ),
        ),
        'alignment' => array(
            'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
            'wrap' => true,
        ),
    ));
}

private function estiloDatos()
{
    return (new \PHPExcel_Style)->applyFromArray(array(
        'font' => array(
            'name' => 'Arial',
            'color' => array(
                'rgb' => '000000',
            ),
        ),
        'fill' => array(
            'type' => \PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array(
                'argb' => 'FFd9b7f4',
            ),
        ),
        'borders' => array(
            'left' => array(
                'style' => \PHPExcel_Style_Border::BORDER_MEDIUM,
                'color' => array(
                    'rgb' => '3a2a47',
                ),
            ),
        ),
    ));
}


















}
