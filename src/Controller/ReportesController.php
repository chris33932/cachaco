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








}
