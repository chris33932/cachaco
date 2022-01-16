<?php

namespace App\Controller;

use App\Entity\EdadLegal;
use App\Form\EdadLegalType;
use App\Repository\EdadLegalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/edad/legal")
 */
class EdadLegalController extends AbstractController
{
    /**
     * @Route("/", name="edad_legal_index", methods={"GET"})
     */
    public function index(EdadLegalRepository $edadLegalRepository): Response
    {
        return $this->render('edad_legal/index.html.twig', [
            'edad_legals' => $edadLegalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="edad_legal_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $edadLegal = new EdadLegal();
        $form = $this->createForm(EdadLegalType::class, $edadLegal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($edadLegal);
            $entityManager->flush();

            return $this->redirectToRoute('edad_legal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('edad_legal/new.html.twig', [
            'edad_legal' => $edadLegal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="edad_legal_show", methods={"GET"})
     */
    public function show(EdadLegal $edadLegal): Response
    {
        return $this->render('edad_legal/show.html.twig', [
            'edad_legal' => $edadLegal,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edad_legal_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, EdadLegal $edadLegal, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EdadLegalType::class, $edadLegal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('edad_legal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('edad_legal/edit.html.twig', [
            'edad_legal' => $edadLegal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="edad_legal_delete", methods={"POST"})
     */
    public function delete(Request $request, EdadLegal $edadLegal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$edadLegal->getId(), $request->request->get('_token'))) {
            $entityManager->remove($edadLegal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('edad_legal_index', [], Response::HTTP_SEE_OTHER);
    }
}
