<?php

namespace App\Controller;

use Twig\Template;
use App\Form\RangoFechaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
     * @Route("/victimas_reportes", name="victimas_reportes")
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
                    'Monto',
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
     * @Route("/victimas_por_edad_legal", name="victimas_por_edad_legal")
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
                    'Monto',
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
     * @Route("/victimas_por_sexo_genero", name="victimas_por_sexo_genero")
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

     //------------------------- VICTIMAS POR MECANISMO DE MUERTE------------------------------//
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
                'reportes/victimas_por_mecanismo.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
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
            'action' => $this->generateUrl('victimas_por_sexo_genero'),
        ));

        $formFechas->handleRequest($request);

        if ($formFechas->isSubmitted() && $formFechas->isValid()) {
            $rangoFecha = $formFechas->getData();
        }

        $em = $this->getDoctrine()->getManager();
        $datos = $em->getRepository('App:Victima')
                    ->presAutorPorSexo($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);
                    

        $datos2 = $em->getRepository('App:Victima')
                    ->presAutorPorGenero($rangoFecha['fechaDesde'], $rangoFecha['fechaHasta']);

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
                'reportes/pres_autor_por_sexo_genero.html.twig',  array(
                    'fecha_desde' => $rangoFecha['fechaDesde'],
                    'fecha_hasta' => $rangoFecha['fechaHasta'],
                    'datos' => $datos,
                    'datos2' => $datos2,
                    'formFechas' => $formFechas->createView()
            ));
        }
    }



      //------------------------- FEMICIDIOS ------------------------------//
    //-------------------------------------------------------------------------------------------//

      /**
     * @Route("/femicidios", name="femicidios")
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
                    'titulo' => 'Victima',
                    'filtro' => array(
                        'Fecha Desde' => $rangoFecha['fechaDesde']->format('d-M-Y'),
                        'Fecha Hasta' => $rangoFecha['fechaHasta']->format('d-M-Y'),
                    ),
                ),
                'columnas' => array(
                    'hecho',
                    'sexo',
                    'femicidio',
                    'victima',
                    'overkill',
                    'domicilio',
                    'fecha',
                    'vinculo',
                    'vinculoTipo',
                    'conviviente',
                    'vinculoTipoOtro',
                    'departamento',
                    'localidad'
                    
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










}
