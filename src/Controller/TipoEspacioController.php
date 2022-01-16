<?php

namespace App\Controller;

use App\Entity\TipoEspacio;
use App\Form\TipoEspacioType;
use App\Repository\TipoEspacioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tipo/espacio")
 */
class TipoEspacioController extends AbstractController
{
    /**
     * @Route("/", name="tipo_espacio_index", methods={"GET"})
     */
    public function index(TipoEspacioRepository $tipoEspacioRepository): Response
    {
        return $this->render('tipo_espacio/index.html.twig', [
            'tipo_espacios' => $tipoEspacioRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tipo_espacio_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tipoEspacio = new TipoEspacio();
        $form = $this->createForm(TipoEspacioType::class, $tipoEspacio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tipoEspacio);
            $entityManager->flush();

            return $this->redirectToRoute('tipo_espacio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tipo_espacio/new.html.twig', [
            'tipo_espacio' => $tipoEspacio,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tipo_espacio_show", methods={"GET"})
     */
    public function show(TipoEspacio $tipoEspacio): Response
    {
        return $this->render('tipo_espacio/show.html.twig', [
            'tipo_espacio' => $tipoEspacio,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipo_espacio_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TipoEspacio $tipoEspacio, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TipoEspacioType::class, $tipoEspacio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('tipo_espacio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tipo_espacio/edit.html.twig', [
            'tipo_espacio' => $tipoEspacio,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tipo_espacio_delete", methods={"POST"})
     */
    public function delete(Request $request, TipoEspacio $tipoEspacio, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tipoEspacio->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tipoEspacio);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tipo_espacio_index', [], Response::HTTP_SEE_OTHER);
    }
}
