<?php

namespace App\Controller;

use App\Entity\NivelInstFormal;
use App\Form\NivelInstFormalType;
use App\Repository\NivelInstFormalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/nivel/inst/formal")
 */
class NivelInstFormalController extends AbstractController
{
    /**
     * @Route("/", name="nivel_inst_formal_index", methods={"GET"})
     */
    public function index(NivelInstFormalRepository $nivelInstFormalRepository): Response
    {
        return $this->render('nivel_inst_formal/index.html.twig', [
            'nivel_inst_formals' => $nivelInstFormalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="nivel_inst_formal_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nivelInstFormal = new NivelInstFormal();
        $form = $this->createForm(NivelInstFormalType::class, $nivelInstFormal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nivelInstFormal);
            $entityManager->flush();

            return $this->redirectToRoute('nivel_inst_formal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('nivel_inst_formal/new.html.twig', [
            'nivel_inst_formal' => $nivelInstFormal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="nivel_inst_formal_show", methods={"GET"})
     */
    public function show(NivelInstFormal $nivelInstFormal): Response
    {
        return $this->render('nivel_inst_formal/show.html.twig', [
            'nivel_inst_formal' => $nivelInstFormal,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="nivel_inst_formal_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, NivelInstFormal $nivelInstFormal, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NivelInstFormalType::class, $nivelInstFormal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('nivel_inst_formal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('nivel_inst_formal/edit.html.twig', [
            'nivel_inst_formal' => $nivelInstFormal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="nivel_inst_formal_delete", methods={"POST"})
     */
    public function delete(Request $request, NivelInstFormal $nivelInstFormal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nivelInstFormal->getId(), $request->request->get('_token'))) {
            $entityManager->remove($nivelInstFormal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('nivel_inst_formal_index', [], Response::HTTP_SEE_OTHER);
    }
}
