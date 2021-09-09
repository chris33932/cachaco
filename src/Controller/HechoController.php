<?php

namespace App\Controller;

use App\Entity\Hecho;
use App\Form\HechoType;
use App\Repository\HechoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hecho")
 */
class HechoController extends AbstractController
{
    /**
     * @Route("/", name="hecho_index", methods={"GET"})
     */
    public function index(HechoRepository $hechoRepository): Response
    {
        return $this->render('hecho/index.html.twig', [
            'hechos' => $hechoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="hecho_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $hecho = new Hecho();
        $form = $this->createForm(HechoType::class, $hecho);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hecho);
            $entityManager->flush();

            return $this->redirectToRoute('hecho_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hecho/new.html.twig', [
            'hecho' => $hecho,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hecho_show", methods={"GET"})
     */
    public function show(Hecho $hecho): Response
    {
        return $this->render('hecho/show.html.twig', [
            'hecho' => $hecho,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="hecho_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Hecho $hecho): Response
    {
        $form = $this->createForm(HechoType::class, $hecho);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hecho_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hecho/edit.html.twig', [
            'hecho' => $hecho,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hecho_delete", methods={"POST"})
     */
    public function delete(Request $request, Hecho $hecho): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hecho->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hecho);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hecho_index', [], Response::HTTP_SEE_OTHER);
    }
}
