<?php

namespace App\Controller;

use App\Entity\Victima;
use App\Form\VictimaType;
use App\Repository\VictimaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/victima")
 */
class VictimaController extends AbstractController
{
    /**
     * @Route("/", name="victima_index", methods={"GET"})
     */
    public function index(VictimaRepository $victimaRepository): Response
    {
        return $this->render('victima/index.html.twig', [
            'victimas' => $victimaRepository->findAll(),
        ]);
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
     * @Route("/{id}", name="victima_show", methods={"GET"})
     */
    public function show(Victima $victima): Response
    {
        return $this->render('victima/show.html.twig', [
            'victima' => $victima,
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
        if ($this->isCsrfTokenValid('delete'.$victima->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($victima);
            $entityManager->flush();
        }

        return $this->redirectToRoute('victima_index', [], Response::HTTP_SEE_OTHER);
    }
}
