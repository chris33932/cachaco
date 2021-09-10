<?php

namespace App\Controller;

use App\Entity\DetalleHecho;
use App\Form\DetalleHechoType;
use App\Repository\DetalleHechoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/detalle/hecho")
 */
class DetalleHechoController extends AbstractController
{
    /**
     * @Route("/", name="detalle_hecho_index", methods={"GET"})
     */
    public function index(DetalleHechoRepository $detalleHechoRepository): Response
    {
        return $this->render('detalle_hecho/index.html.twig', [
            'detalle_hechos' => $detalleHechoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="detalle_hecho_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $detalleHecho = new DetalleHecho();
        $form = $this->createForm(DetalleHechoType::class, $detalleHecho);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($detalleHecho);
            $entityManager->flush();

            return $this->redirectToRoute('detalle_hecho_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('detalle_hecho/new.html.twig', [
            'detalle_hecho' => $detalleHecho,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="detalle_hecho_show", methods={"GET"})
     */
    public function show(DetalleHecho $detalleHecho): Response
    {
        return $this->render('detalle_hecho/show.html.twig', [
            'detalle_hecho' => $detalleHecho,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="detalle_hecho_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, DetalleHecho $detalleHecho): Response
    {
        $form = $this->createForm(DetalleHechoType::class, $detalleHecho);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('detalle_hecho_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('detalle_hecho/edit.html.twig', [
            'detalle_hecho' => $detalleHecho,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="detalle_hecho_delete", methods={"POST"})
     */
    public function delete(Request $request, DetalleHecho $detalleHecho): Response
    {
        if ($this->isCsrfTokenValid('delete'.$detalleHecho->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($detalleHecho);
            $entityManager->flush();
        }

        return $this->redirectToRoute('detalle_hecho_index', [], Response::HTTP_SEE_OTHER);
    }
}
