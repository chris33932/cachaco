<?php

namespace App\Controller;
use App\Entity\DetalleHecho;
use App\Entity\Hecho;
use App\Form\HechoType;
use App\Repository\HechoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/hecho")
 */
class HechoController extends AbstractController
{
    /**
     * @Route("/", name="hecho_index", methods={"GET"})
     */
    public function index(HechoRepository $hechoRepository): Response
    {
        return $this->render('hecho/index.html.twig', [
            'hechos' => $hechoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="hecho_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $hecho = new Hecho();
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
     * @Route("/{id}", name="hecho_show", methods={"GET"})
     */
    public function show(Request $request, $id): Response
    {
               
        $entityManager = $this->getDoctrine()->getManager();
         /**
         * @var $user User
         */
        $hecho = $entityManager->getRepository(Hecho::class)->findOneBy(['id' => $id]);
       
        
        
               //aca iria el embebido 
               $orignalDetalleHecho = new ArrayCollection();
               foreach ($hecho->getDetalleHechos() as $detalle)
               {
                   $orignalDetalleHecho->add($hecho);
                }
                $form = $this->createForm(HechoType::class, $hecho);
                
               $form->handleRequest($request);
               
               if ($form->isSubmitted()) {
                   // get rid of the ones that the user got rid of in the interface (DOM)
                   foreach ($orignalDetalleHecho as $detalle) {
                       // check if the exp is in the $user->getExp()
                      //   dump($user->getExp()->contains($exp));
                       if ($hecho->getDetalleHechos()->contains($detalle) === false) {
                           $entityManager->remove($detalle);
                       }
                   }
                   $entityManager->persist($hecho);
                   
               }
   
               $entityManager->flush();
              // return $this->redirectToRoute('hecho_show', [], Response::HTTP_SEE_OTHER);
      
              
           return $this->render('hecho/new.html.twig', [
               'hecho' => $hecho,
               'form' => $form->createView(),
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
