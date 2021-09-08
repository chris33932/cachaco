<?php

namespace App\Controller;

use App\Entity\SituacionArma;
use App\Form\SituacionArmaType;
use App\Repository\SituacionArmaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/situacion/arma")
 */
class SituacionArmaController extends AbstractController
{
    /**
     * @Route("/", name="situacion_arma_index", methods={"GET"})
     */
    public function index(SituacionArmaRepository $situacionArmaRepository): Response
    {
        return $this->render('situacion_arma/index.html.twig', [
            'situacion_armas' => $situacionArmaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="situacion_arma_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $situacionArma = new SituacionArma();
        $form = $this->createForm(SituacionArmaType::class, $situacionArma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($situacionArma);
            $entityManager->flush();

            return $this->redirectToRoute('situacion_arma_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('situacion_arma/new.html.twig', [
            'situacion_arma' => $situacionArma,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="situacion_arma_show", methods={"GET"})
     */
    public function show(SituacionArma $situacionArma): Response
    {
        return $this->render('situacion_arma/show.html.twig', [
            'situacion_arma' => $situacionArma,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="situacion_arma_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SituacionArma $situacionArma): Response
    {
        $form = $this->createForm(SituacionArmaType::class, $situacionArma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('situacion_arma_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('situacion_arma/edit.html.twig', [
            'situacion_arma' => $situacionArma,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="situacion_arma_delete", methods={"POST"})
     */
    public function delete(Request $request, SituacionArma $situacionArma): Response
    {
        if ($this->isCsrfTokenValid('delete'.$situacionArma->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($situacionArma);
            $entityManager->flush();
        }

        return $this->redirectToRoute('situacion_arma_index', [], Response::HTTP_SEE_OTHER);
    }
}
