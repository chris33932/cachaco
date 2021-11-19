<?php

namespace App\Controller;

use App\Entity\Victima;
use App\Entity\DetalleHecho;
use App\Form\BuscarType;
use App\Form\VictimaType;
use App\Repository\VictimaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/victima")
 */
class VictimaController extends AbstractController
{
    /**
     * @Route("/", name="victima_index", methods={"GET"})
     */
    public function index(Request $request, $filtro=null)
    {
        $repository = $this->getDoctrine()->getRepository(Victima::class);

        if ($filtro){
            $victimas = $repository->findByNombreOId($filtro);
        }
        else
        {
            $victimas = $repository->findBy(
                array(),              //$where
                array(//'anio'=>'DESC',
                       'id' =>'DESC'),  //$orderBy
                //10,                 //$limit
                //0,                  //$offset
            );
        }
        $buscarForm = $this->createForm(BuscarType::class, null, array(
            'action' => $this->generateUrl('victima_buscar'),
        ));

        if ($request->isXmlHttpRequest()){
            $resultado = array();

            foreach($victimas as $victima){
                $resultado[] = array(
                    "label" => $victima->__toString(),
                    "value" => $victima->__toString(),
                    "id" => $victima->getId(),
                    "id" => $victima->getNombre(),
                    "id" => $victima->getApellido(),
                );
            }

            $response = new JsonResponse();
            $response->setStatusCode(200);
            $response->setData(json_encode($resultado, JSON_FORCE_OBJECT));

            return $response;
        }else{
            return $this->render('victima/index.html.twig', array(
                'victimas' => $victimas,
                'buscar' => $buscarForm->createView(),
            ));
        }
    }

   

    /**
     * @Route("/new", name="victima_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $victima = new Victima();
        $form = $this->createForm(VictimaType::class, $victima);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($victima);
            $entityManager->flush();

            return $this->redirectToRoute('victima_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('victima/new.html.twig', [
            'victima' => $victima,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/buscar", name="victima_buscar")
     */
    public function buscarAction(Request $request){
        $filtro = $request->get('buscar')['query'];

        return $this->forward('App\Controller\VictimaController::index', array(
                                'request' => $request,
                                'filtro' => $filtro,
        ));
    }

    /**
     * @Route("/{id}", name="victima_show", methods={"GET"})
     */
    public function show(Victima $victima): Response
    {
        $em = $this->getDoctrine()->getManager();
        $detallehechos = $em->getRepository('App:detalleHecho')->findByVictimaId($victima->getId());
        return $this->render('victima/show.html.twig', [
            'victima' => $victima,
            'detallehechos' => $detallehechos,
        ]);
    }
    

    /**
     * @Route("/{id}/edit", name="victima_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Victima $victima): Response
    {
        $form = $this->createForm(VictimaType::class, $victima);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('victima_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('victima/edit.html.twig', [
            'victima' => $victima,
            'form' => $form->createView(),
        ]);
    }

    

    /**
     * @Route("/{id}", name="victima_delete", methods={"POST"})
     */
    public function delete(Request $request, Victima $victima): Response
    {
        $this->denyAccessUnlessGranted('ROLE_SUPERADMIN', 'No está autorizado');
        if ($this->isCsrfTokenValid('delete'.$victima->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($victima);
            $entityManager->flush();
        }

        return $this->redirectToRoute('victima_index', [], Response::HTTP_SEE_OTHER);
    }
}
