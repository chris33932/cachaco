<?php

namespace App\Controller;

use App\Entity\FuncionMomHecho;
use App\Form\FuncionMomHechoType;
use App\Repository\FuncionMomHechoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/funcion/mom/hecho")
 */
class FuncionMomHechoController extends AbstractController
{
    /**
     * @Route("/", name="funcion_mom_hecho_index", methods={"GET"})
     */
    public function index(FuncionMomHechoRepository $funcionMomHechoRepository): Response
    {
        return $this->render('funcion_mom_hecho/index.html.twig', [
            'funcion_mom_hechos' => $funcionMomHechoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="funcion_mom_hecho_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $funcionMomHecho = new FuncionMomHecho();
        $form = $this->createForm(FuncionMomHechoType::class, $funcionMomHecho);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($funcionMomHecho);
            $entityManager->flush();

            return $this->redirectToRoute('funcion_mom_hecho_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('funcion_mom_hecho/new.html.twig', [
            'funcion_mom_hecho' => $funcionMomHecho,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="funcion_mom_hecho_show", methods={"GET"})
     */
    public function show(FuncionMomHecho $funcionMomHecho): Response
    {
        return $this->render('funcion_mom_hecho/show.html.twig', [
            'funcion_mom_hecho' => $funcionMomHecho,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="funcion_mom_hecho_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, FuncionMomHecho $funcionMomHecho, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FuncionMomHechoType::class, $funcionMomHecho);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('funcion_mom_hecho_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('funcion_mom_hecho/edit.html.twig', [
            'funcion_mom_hecho' => $funcionMomHecho,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="funcion_mom_hecho_delete", methods={"POST"})
     */
    public function delete(Request $request, FuncionMomHecho $funcionMomHecho, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$funcionMomHecho->getId(), $request->request->get('_token'))) {
            $entityManager->remove($funcionMomHecho);
            $entityManager->flush();
        }

        return $this->redirectToRoute('funcion_mom_hecho_index', [], Response::HTTP_SEE_OTHER);
    }
}
