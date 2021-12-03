<?php

namespace App\Controller;

use App\Form\BuscarType;
use App\Entity\PresAutor;
use App\Form\PresAutorType;
use App\Repository\PresAutorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/pres/autor")
 */
class PresAutorController extends AbstractController
{
    /**
     * @Route("/", name="pres_autor_index", methods={"GET"})
     */
    public function index(Request $request,  $filtro=null): Response
    {
        $repository = $this->getDoctrine()->getRepository(PresAutor::class);

        if ($filtro){
            $presautores = $repository->findByNombreOId($filtro);
        }
        else
        {
            $presautores = $repository->findBy(
                array(),              //$where
                array(//'anio'=>'DESC',
                       'id' =>'DESC'),  //$orderBy
                //10,                 //$limit
                //0,                  //$offset
            );
        }
        $buscarForm = $this->createForm(BuscarType::class, null, array(
            'action' => $this->generateUrl('presautor_buscar'),
        ));

        if ($request->isXmlHttpRequest()){
            $resultado = array();

            foreach($presautores as $presautor){
                $resultado[] = array(
                    "label" => $presautor->__toString(),
                    "value" => $presautor->__toString(),
                    "id" => $presautor->getId(),
                    "id" => $presautor->getNombre(),
                    "id" => $presautor->getApellido(),
                );
            }

            $response = new JsonResponse();
            $response->setStatusCode(200);
            $response->setData(json_encode($resultado, JSON_FORCE_OBJECT));

            return $response;
        }else{                  
            return $this->render('pres_autor/index.html.twig', array(
                'presautores' => $presautores,
                'buscar' => $buscarForm->createView(),
            ));
        }
    }

    /**
     * @Route("/new", name="pres_autor_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $presAutor = new PresAutor();
        $form = $this->createForm(PresAutorType::class, $presAutor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($presAutor);
            $entityManager->flush();

            return $this->redirectToRoute('pres_autor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pres_autor/new.html.twig', [
            'pres_autor' => $presAutor,
            'form' => $form->createView(),
        ]);
    }


      /**
     * @Route("/buscar", name="presautor_buscar")
     */
    public function buscarAction(Request $request){
        $filtro = $request->get('buscar')['query'];

        return $this->forward('App\Controller\PresAutorController::index', array(
                                'request' => $request,
                                'filtro' => $filtro,
        ));
    }




    /**
     * @Route("/{id}", name="pres_autor_show", methods={"GET"})
     */
    public function show(PresAutor $presAutor): Response
    {
        $em = $this->getDoctrine()->getManager();
        $detallehechos = $em->getRepository('App:detalleHecho')->findByPresAutorId($presAutor->getId());
       
        return $this->render('pres_autor/show.html.twig', [
            'pres_autor' => $presAutor,
            'detallehechos' => $detallehechos,

        ]);
    }

    /**
     * @Route("/{id}/edit", name="pres_autor_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PresAutor $presAutor): Response
    {
        $form = $this->createForm(PresAutorType::class, $presAutor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pres_autor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pres_autor/edit.html.twig', [
            'pres_autor' => $presAutor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pres_autor_delete", methods={"POST"})
     */
    public function delete(Request $request, PresAutor $presAutor): Response
    {
        if ($this->isCsrfTokenValid('delete'.$presAutor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($presAutor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pres_autor_index', [], Response::HTTP_SEE_OTHER);
    }
}
