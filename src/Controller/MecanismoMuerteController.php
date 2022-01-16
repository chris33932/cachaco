<?php

namespace App\Controller;

use App\Entity\MecanismoMuerte;
use App\Form\MecanismoMuerteType;
use App\Repository\MecanismoMuerteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mecanismo/muerte")
 */
class MecanismoMuerteController extends AbstractController
{
    /**
     * @Route("/", name="mecanismo_muerte_index", methods={"GET"})
     */
    public function index(MecanismoMuerteRepository $mecanismoMuerteRepository): Response
    {
        return $this->render('mecanismo_muerte/index.html.twig', [
            'mecanismo_muertes' => $mecanismoMuerteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="mecanismo_muerte_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mecanismoMuerte = new MecanismoMuerte();
        $form = $this->createForm(MecanismoMuerteType::class, $mecanismoMuerte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mecanismoMuerte);
            $entityManager->flush();

            return $this->redirectToRoute('mecanismo_muerte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mecanismo_muerte/new.html.twig', [
            'mecanismo_muerte' => $mecanismoMuerte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mecanismo_muerte_show", methods={"GET"})
     */
    public function show(MecanismoMuerte $mecanismoMuerte): Response
    {
        return $this->render('mecanismo_muerte/show.html.twig', [
            'mecanismo_muerte' => $mecanismoMuerte,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mecanismo_muerte_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, MecanismoMuerte $mecanismoMuerte, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MecanismoMuerteType::class, $mecanismoMuerte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('mecanismo_muerte_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mecanismo_muerte/edit.html.twig', [
            'mecanismo_muerte' => $mecanismoMuerte,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mecanismo_muerte_delete", methods={"POST"})
     */
    public function delete(Request $request, MecanismoMuerte $mecanismoMuerte, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mecanismoMuerte->getId(), $request->request->get('_token'))) {
            $entityManager->remove($mecanismoMuerte);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mecanismo_muerte_index', [], Response::HTTP_SEE_OTHER);
    }
}
