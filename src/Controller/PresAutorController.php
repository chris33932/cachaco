<?php

namespace App\Controller;

use App\Entity\PresAutor;
use App\Form\PresAutorType;
use App\Repository\PresAutorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pres/autor")
 */
class PresAutorController extends AbstractController
{
    /**
     * @Route("/", name="pres_autor_index", methods={"GET"})
     */
    public function index(PresAutorRepository $presAutorRepository): Response
    {
        return $this->render('pres_autor/index.html.twig', [
            'pres_autors' => $presAutorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pres_autor_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $presAutor = new PresAutor();
        $form = $this->createForm(PresAutorType::class, $presAutor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($presAutor);
            $entityManager->flush();

            return $this->redirectToRoute('pres_autor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pres_autor/new.html.twig', [
            'pres_autor' => $presAutor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pres_autor_show", methods={"GET"})
     */
    public function show(PresAutor $presAutor): Response
    {
        return $this->render('pres_autor/show.html.twig', [
            'pres_autor' => $presAutor,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pres_autor_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PresAutor $presAutor): Response
    {
        $form = $this->createForm(PresAutorType::class, $presAutor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pres_autor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pres_autor/edit.html.twig', [
            'pres_autor' => $presAutor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pres_autor_delete", methods={"POST"})
     */
    public function delete(Request $request, PresAutor $presAutor): Response
    {
        if ($this->isCsrfTokenValid('delete'.$presAutor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($presAutor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pres_autor_index', [], Response::HTTP_SEE_OTHER);
    }
}
