<?php

namespace App\Controller;

use App\Entity\TipoFemicidio;
use App\Form\TipoFemicidioType;
use App\Repository\TipoFemicidioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tipo/femicidio")
 */
class TipoFemicidioController extends AbstractController
{
    /**
     * @Route("/", name="tipo_femicidio_index", methods={"GET"})
     */
    public function index(TipoFemicidioRepository $tipoFemicidioRepository): Response
    {
        return $this->render('tipo_femicidio/index.html.twig', [
            'tipo_femicidios' => $tipoFemicidioRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tipo_femicidio_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tipoFemicidio = new TipoFemicidio();
        $form = $this->createForm(TipoFemicidioType::class, $tipoFemicidio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tipoFemicidio);
            $entityManager->flush();

            return $this->redirectToRoute('tipo_femicidio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tipo_femicidio/new.html.twig', [
            'tipo_femicidio' => $tipoFemicidio,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tipo_femicidio_show", methods={"GET"})
     */
    public function show(TipoFemicidio $tipoFemicidio): Response
    {
        return $this->render('tipo_femicidio/show.html.twig', [
            'tipo_femicidio' => $tipoFemicidio,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipo_femicidio_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, TipoFemicidio $tipoFemicidio, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TipoFemicidioType::class, $tipoFemicidio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('tipo_femicidio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tipo_femicidio/edit.html.twig', [
            'tipo_femicidio' => $tipoFemicidio,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tipo_femicidio_delete", methods={"POST"})
     */
    public function delete(Request $request, TipoFemicidio $tipoFemicidio, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tipoFemicidio->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tipoFemicidio);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tipo_femicidio_index', [], Response::HTTP_SEE_OTHER);
    }
}
