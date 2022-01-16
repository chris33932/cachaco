<?php

namespace App\Controller;

use App\Entity\OcasionDelito;
use App\Form\OcasionDelitoType;
use App\Repository\OcasionDelitoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ocasion/delito")
 */
class OcasionDelitoController extends AbstractController
{
    /**
     * @Route("/", name="ocasion_delito_index", methods={"GET"})
     */
    public function index(OcasionDelitoRepository $ocasionDelitoRepository): Response
    {
        return $this->render('ocasion_delito/index.html.twig', [
            'ocasion_delitos' => $ocasionDelitoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ocasion_delito_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ocasionDelito = new OcasionDelito();
        $form = $this->createForm(OcasionDelitoType::class, $ocasionDelito);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ocasionDelito);
            $entityManager->flush();

            return $this->redirectToRoute('ocasion_delito_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ocasion_delito/new.html.twig', [
            'ocasion_delito' => $ocasionDelito,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ocasion_delito_show", methods={"GET"})
     */
    public function show(OcasionDelito $ocasionDelito): Response
    {
        return $this->render('ocasion_delito/show.html.twig', [
            'ocasion_delito' => $ocasionDelito,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ocasion_delito_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, OcasionDelito $ocasionDelito, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OcasionDelitoType::class, $ocasionDelito);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('ocasion_delito_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ocasion_delito/edit.html.twig', [
            'ocasion_delito' => $ocasionDelito,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ocasion_delito_delete", methods={"POST"})
     */
    public function delete(Request $request, OcasionDelito $ocasionDelito, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ocasionDelito->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ocasionDelito);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ocasion_delito_index', [], Response::HTTP_SEE_OTHER);
    }
}
