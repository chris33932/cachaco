<?php

namespace App\Controller;

use App\Entity\Nacionalidad;
use App\Form\NacionalidadType;
use App\Repository\NacionalidadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/nacionalidad")
 */
class NacionalidadController extends AbstractController
{
    /**
     * @Route("/", name="nacionalidad_index", methods={"GET"})
     */
    public function index(NacionalidadRepository $nacionalidadRepository): Response
    {
        return $this->render('nacionalidad/index.html.twig', [
            'nacionalidads' => $nacionalidadRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="nacionalidad_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nacionalidad = new Nacionalidad();
        $form = $this->createForm(NacionalidadType::class, $nacionalidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nacionalidad);
            $entityManager->flush();

            return $this->redirectToRoute('nacionalidad_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('nacionalidad/new.html.twig', [
            'nacionalidad' => $nacionalidad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="nacionalidad_show", methods={"GET"})
     */
    public function show(Nacionalidad $nacionalidad): Response
    {
        return $this->render('nacionalidad/show.html.twig', [
            'nacionalidad' => $nacionalidad,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="nacionalidad_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Nacionalidad $nacionalidad, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NacionalidadType::class, $nacionalidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('nacionalidad_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('nacionalidad/edit.html.twig', [
            'nacionalidad' => $nacionalidad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="nacionalidad_delete", methods={"POST"})
     */
    public function delete(Request $request, Nacionalidad $nacionalidad, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nacionalidad->getId(), $request->request->get('_token'))) {
            $entityManager->remove($nacionalidad);
            $entityManager->flush();
        }

        return $this->redirectToRoute('nacionalidad_index', [], Response::HTTP_SEE_OTHER);
    }
}
