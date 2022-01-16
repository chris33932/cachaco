<?php

namespace App\Controller;

use App\Entity\OrigenRegistro;
use App\Form\OrigenRegistroType;
use App\Repository\OrigenRegistroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/origen/registro")
 */
class OrigenRegistroController extends AbstractController
{
    /**
     * @Route("/", name="origen_registro_index", methods={"GET"})
     */
    public function index(OrigenRegistroRepository $origenRegistroRepository): Response
    {
        return $this->render('origen_registro/index.html.twig', [
            'origen_registros' => $origenRegistroRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="origen_registro_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $origenRegistro = new OrigenRegistro();
        $form = $this->createForm(OrigenRegistroType::class, $origenRegistro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($origenRegistro);
            $entityManager->flush();

            return $this->redirectToRoute('origen_registro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('origen_registro/new.html.twig', [
            'origen_registro' => $origenRegistro,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="origen_registro_show", methods={"GET"})
     */
    public function show(OrigenRegistro $origenRegistro): Response
    {
        return $this->render('origen_registro/show.html.twig', [
            'origen_registro' => $origenRegistro,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="origen_registro_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, OrigenRegistro $origenRegistro, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrigenRegistroType::class, $origenRegistro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('origen_registro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('origen_registro/edit.html.twig', [
            'origen_registro' => $origenRegistro,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="origen_registro_delete", methods={"POST"})
     */
    public function delete(Request $request, OrigenRegistro $origenRegistro, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$origenRegistro->getId(), $request->request->get('_token'))) {
            $entityManager->remove($origenRegistro);
            $entityManager->flush();
        }

        return $this->redirectToRoute('origen_registro_index', [], Response::HTTP_SEE_OTHER);
    }
}
