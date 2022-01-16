<?php

namespace App\Controller;

use App\Entity\Tipologia;
use App\Form\TipologiaType;
use App\Repository\TipologiaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tipologia")
 */
class TipologiaController extends AbstractController
{
    /**
     * @Route("/", name="tipologia_index", methods={"GET"})
     */
    public function index(TipologiaRepository $tipologiaRepository): Response
    {
        return $this->render('tipologia/index.html.twig', [
            'tipologias' => $tipologiaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tipologia_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tipologium = new Tipologia();
        $form = $this->createForm(TipologiaType::class, $tipologium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tipologium);
            $entityManager->flush();

            return $this->redirectToRoute('tipologia_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tipologia/new.html.twig', [
            'tipologium' => $tipologium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tipologia_show", methods={"GET"})
     */
    public function show(Tipologia $tipologium): Response
    {
        return $this->render('tipologia/show.html.twig', [
            'tipologium' => $tipologium,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipologia_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Tipologia $tipologium, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TipologiaType::class, $tipologium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('tipologia_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tipologia/edit.html.twig', [
            'tipologium' => $tipologium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tipologia_delete", methods={"POST"})
     */
    public function delete(Request $request, Tipologia $tipologium, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tipologium->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tipologium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tipologia_index', [], Response::HTTP_SEE_OTHER);
    }
}
