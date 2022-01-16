<?php

namespace App\Controller;

use App\Entity\EstadoIntox;
use App\Form\EstadoIntoxType;
use App\Repository\EstadoIntoxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/estado/intox")
 */
class EstadoIntoxController extends AbstractController
{
    /**
     * @Route("/", name="estado_intox_index", methods={"GET"})
     */
    public function index(EstadoIntoxRepository $estadoIntoxRepository): Response
    {
        return $this->render('estado_intox/index.html.twig', [
            'estado_intoxes' => $estadoIntoxRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="estado_intox_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $estadoIntox = new EstadoIntox();
        $form = $this->createForm(EstadoIntoxType::class, $estadoIntox);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($estadoIntox);
            $entityManager->flush();

            return $this->redirectToRoute('estado_intox_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estado_intox/new.html.twig', [
            'estado_intox' => $estadoIntox,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="estado_intox_show", methods={"GET"})
     */
    public function show(EstadoIntox $estadoIntox): Response
    {
        return $this->render('estado_intox/show.html.twig', [
            'estado_intox' => $estadoIntox,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="estado_intox_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, EstadoIntox $estadoIntox, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EstadoIntoxType::class, $estadoIntox);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('estado_intox_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estado_intox/edit.html.twig', [
            'estado_intox' => $estadoIntox,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="estado_intox_delete", methods={"POST"})
     */
    public function delete(Request $request, EstadoIntox $estadoIntox, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$estadoIntox->getId(), $request->request->get('_token'))) {
            $entityManager->remove($estadoIntox);
            $entityManager->flush();
        }

        return $this->redirectToRoute('estado_intox_index', [], Response::HTTP_SEE_OTHER);
    }
}
