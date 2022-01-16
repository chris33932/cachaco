<?php

namespace App\Controller;

use App\Entity\TipoLugar;
use App\Form\TipoLugarType;
use App\Repository\TipoLugarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tipo/lugar")
 */
class TipoLugarController extends AbstractController
{
    /**
     * @Route("/", name="tipo_lugar_index", methods={"GET"})
     */
    public function index(TipoLugarRepository $tipoLugarRepository): Response
    {
        return $this->render('tipo_lugar/index.html.twig', [
            'tipo_lugars' => $tipoLugarRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tipo_lugar_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tipoLugar = new TipoLugar();
        $form = $this->createForm(TipoLugarType::class, $tipoLugar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tipoLugar);
            $entityManager->flush();

            return $this->redirectToRoute('tipo_lugar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tipo_lugar/new.html.twig', [
            'tipo_lugar' => $tipoLugar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tipo_lugar_show", methods={"GET"})
     */
    public function show(TipoLugar $tipoLugar): Response
    {
        return $this->render('tipo_lugar/show.html.twig', [
            'tipo_lugar' => $tipoLugar,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipo_lugar_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TipoLugar $tipoLugar, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TipoLugarType::class, $tipoLugar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('tipo_lugar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tipo_lugar/edit.html.twig', [
            'tipo_lugar' => $tipoLugar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tipo_lugar_delete", methods={"POST"})
     */
    public function delete(Request $request, TipoLugar $tipoLugar, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tipoLugar->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tipoLugar);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tipo_lugar_index', [], Response::HTTP_SEE_OTHER);
    }
}
