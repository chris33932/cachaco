<?php

namespace App\Controller;

use App\Entity\CompHecho;
use App\Form\CompHechoType;
use App\Repository\CompHechoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/comp/hecho")
 */
class CompHechoController extends AbstractController
{
    /**
     * @Route("/", name="comp_hecho_index", methods={"GET"})
     */
    public function index(CompHechoRepository $compHechoRepository): Response
    {
        return $this->render('comp_hecho/index.html.twig', [
            'comp_hechos' => $compHechoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="comp_hecho_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $compHecho = new CompHecho();
        $form = $this->createForm(CompHechoType::class, $compHecho);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($compHecho);
            $entityManager->flush();

            return $this->redirectToRoute('comp_hecho_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comp_hecho/new.html.twig', [
            'comp_hecho' => $compHecho,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comp_hecho_show", methods={"GET"})
     */
    public function show(CompHecho $compHecho): Response
    {
        return $this->render('comp_hecho/show.html.twig', [
            'comp_hecho' => $compHecho,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="comp_hecho_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CompHecho $compHecho): Response
    {
        $form = $this->createForm(CompHechoType::class, $compHecho);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comp_hecho_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comp_hecho/edit.html.twig', [
            'comp_hecho' => $compHecho,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comp_hecho_delete", methods={"POST"})
     */
    public function delete(Request $request, CompHecho $compHecho): Response
    {
        if ($this->isCsrfTokenValid('delete'.$compHecho->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($compHecho);
            $entityManager->flush();
        }

        return $this->redirectToRoute('comp_hecho_index', [], Response::HTTP_SEE_OTHER);
    }
}
