<?php

namespace App\Controller;
use App\Entity\Hecho;
use App\Form\HechoType;
use App\Entity\DetalleHecho;
use App\Form\BuscarType;
use App\Repository\HechoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/hecho")
 */
class HechoController extends AbstractController
{
    /**
     * @Route("/", name="hecho_index", methods={"GET"})
     */
    public function index(Request $request, $filtro=null, HechoRepository $hechoRepository): Response
    {

        if($filtro){
            $hechos= $hechoRepository->findBynroPreventivoOId($filtro);

        }
        else
        {
            $hechos=$hechoRepository->findBy(
                array(),              //$where
                array('anio'=>'DESC',
                       'id' =>'DESC'),  //$orderBy
                //10,                 //$limit
                //0,                  //$offset
            );
        }
        $buscarForm = $this->createForm(BuscarType::class, null, array(
            'action' => $this->generateUrl('hecho_buscar'),
        ));

        if ($request->isXmlHttpRequest()){
            $resultado = array();

            foreach($hechos as $hecho){
                $resultado[] = array(
                    "label" => $hecho->__toString(),
                    "value" => $hecho->__toString(),
                    "id" => $hecho->getId(),
                    "id" => $hecho->getNroPreventivo(),
                    "id" => $hecho->getAnio(),
                    
                );
            }

            $response = new JsonResponse();
            $response->setStatusCode(200);
            $response->setData(json_encode($resultado, JSON_FORCE_OBJECT));

            return $response;
        }else{
        return $this->render('hecho/index.html.twig', [
            'hechos' => $hechos,
            'buscar' => $buscarForm->createView(),
        ]);
    }
    }

    /**
     * @Route("/new", name="hecho_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $hecho = new Hecho();
        $username = $this->getUser()->getUsername();
        $hecho->setCreado($username);
        $form = $this->createForm(HechoType::class, $hecho);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hecho);

            //aca iria el embebido 
            $orignalDetalleHecho = new ArrayCollection();
            foreach ($hecho->getDetalleHechos() as $detalle)
            {
                $orignalDetalleHecho->add($hecho);
             }
             $form = $this->createForm(HechoType::class, $hecho);
             
            $form->handleRequest($request);
            
            if ($form->isSubmitted()) {
               
           // deshacerse de los que el usuario eliminó en la interfaz (DOM)
                foreach ($orignalDetalleHecho as $detalle) {
                  
                    if ($hecho->getDetalleHechos()->contains($detalle) === false) {
                        $entityManager->remove($detalle);
                    }
                }
                $entityManager->persist($hecho);
                
            }

            $entityManager->flush();

            return $this->redirectToRoute('hecho_index');

            //return $this->redirectToRoute('hecho_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hecho/new.html.twig', [
            'hecho' => $hecho,
            'form' => $form->createView(),
        ]);
        
    }

     /**
     * @Route("/buscar", name="hecho_buscar")
     */
    public function buscarAction(Request $request){
        $filtro = $request->get('buscar')['query'];

        return $this->forward('App\Controller\HechoController::index', array(
                                'request' => $request,
                                'filtro' => $filtro,
        ));
    }

    



    /**
     * @Route("/{id}", name="hecho_show", methods={"GET"})
     */
    public function show(Hecho $hecho): Response
    {
               
        $em = $this->getDoctrine()->getManager();
        $detallehechos = $em->getRepository('App:detalleHecho')->findByHechoId($hecho->getId());
        return $this->render('hecho/show.html.twig', [
            'hecho' => $hecho,
            'detallehechos' => $detallehechos,
        ]);
              
          
       }




       




    /**
     * @Route("/{id}/edit", name="hecho_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Hecho $hecho): Response
    {
        $form = $this->createForm(HechoType::class, $hecho);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hecho_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hecho/edit.html.twig', [
            'hecho' => $hecho,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hecho_delete", methods={"POST"})
     */
    public function delete(Request $request, Hecho $hecho): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hecho->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hecho);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hecho_index', [], Response::HTTP_SEE_OTHER);
    }
}
