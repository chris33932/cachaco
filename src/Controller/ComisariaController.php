<?php

namespace App\Controller;

use App\Entity\Comisaria;
use App\Form\ComisariaType;
use App\Repository\ComisariaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/comisaria")
 */
class ComisariaController extends AbstractController
{
    /**
     * @Route("/", name="comisaria_index", methods={"GET"})
     */
    public function index(ComisariaRepository $comisariaRepository): Response
    {
        return $this->render('comisaria/index.html.twig', [
            'comisarias' => $comisariaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="comisaria_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $comisarium = new Comisaria();
        $form = $this->createForm(ComisariaType::class, $comisarium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comisarium);
            $entityManager->flush();

            return $this->redirectToRoute('comisaria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comisaria/new.html.twig', [
            'comisarium' => $comisarium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comisaria_show", methods={"GET"})
     */
    public function show(Comisaria $comisarium): Response
    {
        return $this->render('comisaria/show.html.twig', [
            'comisarium' => $comisarium,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="comisaria_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Comisaria $comisarium): Response
    {
        $form = $this->createForm(ComisariaType::class, $comisarium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comisaria_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comisaria/edit.html.twig', [
            'comisarium' => $comisarium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comisaria_delete", methods={"POST"})
     */
    public function delete(Request $request, Comisaria $comisarium): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comisarium->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comisarium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('comisaria_index', [], Response::HTTP_SEE_OTHER);
    }
}
