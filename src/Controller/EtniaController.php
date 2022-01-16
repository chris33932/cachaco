<?php

namespace App\Controller;

use App\Entity\Etnia;
use App\Form\EtniaType;
use App\Repository\EtniaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/etnia")
 */
class EtniaController extends AbstractController
{
    /**
     * @Route("/", name="etnia_index", methods={"GET"})
     */
    public function index(EtniaRepository $etniaRepository): Response
    {
        return $this->render('etnia/index.html.twig', [
            'etnias' => $etniaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="etnia_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $etnium = new Etnia();
        $form = $this->createForm(EtniaType::class, $etnium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etnium);
            $entityManager->flush();

            return $this->redirectToRoute('etnia_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etnia/new.html.twig', [
            'etnium' => $etnium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="etnia_show", methods={"GET"})
     */
    public function show(Etnia $etnium): Response
    {
        return $this->render('etnia/show.html.twig', [
            'etnium' => $etnium,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="etnia_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Etnia $etnium, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtniaType::class, $etnium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('etnia_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etnia/edit.html.twig', [
            'etnium' => $etnium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="etnia_delete", methods={"POST"})
     */
    public function delete(Request $request, Etnia $etnium, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etnium->getId(), $request->request->get('_token'))) {
            $entityManager->remove($etnium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('etnia_index', [], Response::HTTP_SEE_OTHER);
    }
}
