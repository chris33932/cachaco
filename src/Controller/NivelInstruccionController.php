<?php

namespace App\Controller;

use App\Entity\NivelInstruccion;
use App\Form\NivelInstruccionType;
use App\Repository\NivelInstruccionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/nivel/instruccion")
 */
class NivelInstruccionController extends AbstractController
{
    /**
     * @Route("/", name="nivel_instruccion_index", methods={"GET"})
     */
    public function index(NivelInstruccionRepository $nivelInstruccionRepository): Response
    {
        return $this->render('nivel_instruccion/index.html.twig', [
            'nivel_instruccions' => $nivelInstruccionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="nivel_instruccion_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nivelInstruccion = new NivelInstruccion();
        $form = $this->createForm(NivelInstruccionType::class, $nivelInstruccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nivelInstruccion);
            $entityManager->flush();

            return $this->redirectToRoute('nivel_instruccion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('nivel_instruccion/new.html.twig', [
            'nivel_instruccion' => $nivelInstruccion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="nivel_instruccion_show", methods={"GET"})
     */
    public function show(NivelInstruccion $nivelInstruccion): Response
    {
        return $this->render('nivel_instruccion/show.html.twig', [
            'nivel_instruccion' => $nivelInstruccion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="nivel_instruccion_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NivelInstruccion $nivelInstruccion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NivelInstruccionType::class, $nivelInstruccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('nivel_instruccion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('nivel_instruccion/edit.html.twig', [
            'nivel_instruccion' => $nivelInstruccion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="nivel_instruccion_delete", methods={"POST"})
     */
    public function delete(Request $request, NivelInstruccion $nivelInstruccion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nivelInstruccion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($nivelInstruccion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('nivel_instruccion_index', [], Response::HTTP_SEE_OTHER);
    }
}
