<?php

namespace App\Controller;

use App\Entity\CondicionActividad;
use App\Form\CondicionActividadType;
use App\Repository\CondicionActividadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/condicion/actividad")
 */
class CondicionActividadController extends AbstractController
{
    /**
     * @Route("/", name="condicion_actividad_index", methods={"GET"})
     */
    public function index(CondicionActividadRepository $condicionActividadRepository): Response
    {
        return $this->render('condicion_actividad/index.html.twig', [
            'condicion_actividads' => $condicionActividadRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="condicion_actividad_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $condicionActividad = new CondicionActividad();
        $form = $this->createForm(CondicionActividadType::class, $condicionActividad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($condicionActividad);
            $entityManager->flush();

            return $this->redirectToRoute('condicion_actividad_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('condicion_actividad/new.html.twig', [
            'condicion_actividad' => $condicionActividad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="condicion_actividad_show", methods={"GET"})
     */
    public function show(CondicionActividad $condicionActividad): Response
    {
        return $this->render('condicion_actividad/show.html.twig', [
            'condicion_actividad' => $condicionActividad,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="condicion_actividad_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CondicionActividad $condicionActividad, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CondicionActividadType::class, $condicionActividad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('condicion_actividad_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('condicion_actividad/edit.html.twig', [
            'condicion_actividad' => $condicionActividad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="condicion_actividad_delete", methods={"POST"})
     */
    public function delete(Request $request, CondicionActividad $condicionActividad, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$condicionActividad->getId(), $request->request->get('_token'))) {
            $entityManager->remove($condicionActividad);
            $entityManager->flush();
        }

        return $this->redirectToRoute('condicion_actividad_index', [], Response::HTTP_SEE_OTHER);
    }
}
