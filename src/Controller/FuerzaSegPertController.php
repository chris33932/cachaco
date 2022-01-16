<?php

namespace App\Controller;

use App\Entity\FuerzaSegPert;
use App\Form\FuerzaSegPertType;
use App\Repository\FuerzaSegPertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/fuerza/seg/pert")
 */
class FuerzaSegPertController extends AbstractController
{
    /**
     * @Route("/", name="fuerza_seg_pert_index", methods={"GET"})
     */
    public function index(FuerzaSegPertRepository $fuerzaSegPertRepository): Response
    {
        return $this->render('fuerza_seg_pert/index.html.twig', [
            'fuerza_seg_perts' => $fuerzaSegPertRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="fuerza_seg_pert_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $fuerzaSegPert = new FuerzaSegPert();
        $form = $this->createForm(FuerzaSegPertType::class, $fuerzaSegPert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($fuerzaSegPert);
            $entityManager->flush();

            return $this->redirectToRoute('fuerza_seg_pert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fuerza_seg_pert/new.html.twig', [
            'fuerza_seg_pert' => $fuerzaSegPert,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fuerza_seg_pert_show", methods={"GET"})
     */
    public function show(FuerzaSegPert $fuerzaSegPert): Response
    {
        return $this->render('fuerza_seg_pert/show.html.twig', [
            'fuerza_seg_pert' => $fuerzaSegPert,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="fuerza_seg_pert_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, FuerzaSegPert $fuerzaSegPert, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FuerzaSegPertType::class, $fuerzaSegPert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('fuerza_seg_pert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fuerza_seg_pert/edit.html.twig', [
            'fuerza_seg_pert' => $fuerzaSegPert,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="fuerza_seg_pert_delete", methods={"POST"})
     */
    public function delete(Request $request, FuerzaSegPert $fuerzaSegPert, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fuerzaSegPert->getId(), $request->request->get('_token'))) {
            $entityManager->remove($fuerzaSegPert);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fuerza_seg_pert_index', [], Response::HTTP_SEE_OTHER);
    }
}
