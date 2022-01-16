<?php

namespace App\Controller;

use App\Entity\ContFemicida;
use App\Form\ContFemicidaType;
use App\Repository\ContFemicidaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cont/femicida")
 */
class ContFemicidaController extends AbstractController
{
    /**
     * @Route("/", name="cont_femicida_index", methods={"GET"})
     */
    public function index(ContFemicidaRepository $contFemicidaRepository): Response
    {
        return $this->render('cont_femicida/index.html.twig', [
            'cont_femicidas' => $contFemicidaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cont_femicida_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contFemicida = new ContFemicida();
        $form = $this->createForm(ContFemicidaType::class, $contFemicida);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contFemicida);
            $entityManager->flush();

            return $this->redirectToRoute('cont_femicida_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cont_femicida/new.html.twig', [
            'cont_femicida' => $contFemicida,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cont_femicida_show", methods={"GET"})
     */
    public function show(ContFemicida $contFemicida): Response
    {
        return $this->render('cont_femicida/show.html.twig', [
            'cont_femicida' => $contFemicida,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cont_femicida_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ContFemicida $contFemicida, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContFemicidaType::class, $contFemicida);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('cont_femicida_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cont_femicida/edit.html.twig', [
            'cont_femicida' => $contFemicida,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cont_femicida_delete", methods={"POST"})
     */
    public function delete(Request $request, ContFemicida $contFemicida, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contFemicida->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contFemicida);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cont_femicida_index', [], Response::HTTP_SEE_OTHER);
    }
}
