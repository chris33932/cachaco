<?php

namespace App\Controller;

use App\Entity\TipoPerArma;
use App\Form\TipoPerArmaType;
use App\Repository\TipoPerArmaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tipo/per/arma")
 */
class TipoPerArmaController extends AbstractController
{
    /**
     * @Route("/", name="tipo_per_arma_index", methods={"GET"})
     */
    public function index(TipoPerArmaRepository $tipoPerArmaRepository): Response
    {
        return $this->render('tipo_per_arma/index.html.twig', [
            'tipo_per_armas' => $tipoPerArmaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tipo_per_arma_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tipoPerArma = new TipoPerArma();
        $form = $this->createForm(TipoPerArmaType::class, $tipoPerArma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tipoPerArma);
            $entityManager->flush();

            return $this->redirectToRoute('tipo_per_arma_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tipo_per_arma/new.html.twig', [
            'tipo_per_arma' => $tipoPerArma,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tipo_per_arma_show", methods={"GET"})
     */
    public function show(TipoPerArma $tipoPerArma): Response
    {
        return $this->render('tipo_per_arma/show.html.twig', [
            'tipo_per_arma' => $tipoPerArma,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipo_per_arma_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TipoPerArma $tipoPerArma): Response
    {
        $form = $this->createForm(TipoPerArmaType::class, $tipoPerArma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tipo_per_arma_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tipo_per_arma/edit.html.twig', [
            'tipo_per_arma' => $tipoPerArma,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tipo_per_arma_delete", methods={"POST"})
     */
    public function delete(Request $request, TipoPerArma $tipoPerArma): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tipoPerArma->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tipoPerArma);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tipo_per_arma_index', [], Response::HTTP_SEE_OTHER);
    }
}
