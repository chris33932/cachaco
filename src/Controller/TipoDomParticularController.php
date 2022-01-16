<?php

namespace App\Controller;

use App\Entity\TipoDomParticular;
use App\Form\TipoDomParticularType;
use App\Repository\TipoDomParticularRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tipo/dom/particular")
 */
class TipoDomParticularController extends AbstractController
{
    /**
     * @Route("/", name="tipo_dom_particular_index", methods={"GET"})
     */
    public function index(TipoDomParticularRepository $tipoDomParticularRepository): Response
    {
        return $this->render('tipo_dom_particular/index.html.twig', [
            'tipo_dom_particulars' => $tipoDomParticularRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tipo_dom_particular_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tipoDomParticular = new TipoDomParticular();
        $form = $this->createForm(TipoDomParticularType::class, $tipoDomParticular);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tipoDomParticular);
            $entityManager->flush();

            return $this->redirectToRoute('tipo_dom_particular_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tipo_dom_particular/new.html.twig', [
            'tipo_dom_particular' => $tipoDomParticular,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tipo_dom_particular_show", methods={"GET"})
     */
    public function show(TipoDomParticular $tipoDomParticular): Response
    {
        return $this->render('tipo_dom_particular/show.html.twig', [
            'tipo_dom_particular' => $tipoDomParticular,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipo_dom_particular_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TipoDomParticular $tipoDomParticular, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TipoDomParticularType::class, $tipoDomParticular);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('tipo_dom_particular_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tipo_dom_particular/edit.html.twig', [
            'tipo_dom_particular' => $tipoDomParticular,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tipo_dom_particular_delete", methods={"POST"})
     */
    public function delete(Request $request, TipoDomParticular $tipoDomParticular, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tipoDomParticular->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tipoDomParticular);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tipo_dom_particular_index', [], Response::HTTP_SEE_OTHER);
    }
}
