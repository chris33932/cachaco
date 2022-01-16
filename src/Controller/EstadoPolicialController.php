<?php

namespace App\Controller;

use App\Entity\EstadoPolicial;
use App\Form\EstadoPolicialType;
use App\Repository\EstadoPolicialRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/estado/policial")
 */
class EstadoPolicialController extends AbstractController
{
    /**
     * @Route("/", name="estado_policial_index", methods={"GET"})
     */
    public function index(EstadoPolicialRepository $estadoPolicialRepository): Response
    {
        return $this->render('estado_policial/index.html.twig', [
            'estado_policials' => $estadoPolicialRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="estado_policial_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $estadoPolicial = new EstadoPolicial();
        $form = $this->createForm(EstadoPolicialType::class, $estadoPolicial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($estadoPolicial);
            $entityManager->flush();

            return $this->redirectToRoute('estado_policial_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estado_policial/new.html.twig', [
            'estado_policial' => $estadoPolicial,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="estado_policial_show", methods={"GET"})
     */
    public function show(EstadoPolicial $estadoPolicial): Response
    {
        return $this->render('estado_policial/show.html.twig', [
            'estado_policial' => $estadoPolicial,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="estado_policial_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, EstadoPolicial $estadoPolicial, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EstadoPolicialType::class, $estadoPolicial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('estado_policial_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estado_policial/edit.html.twig', [
            'estado_policial' => $estadoPolicial,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="estado_policial_delete", methods={"POST"})
     */
    public function delete(Request $request, EstadoPolicial $estadoPolicial, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$estadoPolicial->getId(), $request->request->get('_token'))) {
            $entityManager->remove($estadoPolicial);
            $entityManager->flush();
        }

        return $this->redirectToRoute('estado_policial_index', [], Response::HTTP_SEE_OTHER);
    }
}
