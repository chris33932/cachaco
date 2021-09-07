<?php

namespace App\Controller;

use App\Entity\SituacionLaboral;
use App\Form\SituacionLaboralType;
use App\Repository\SituacionLaboralRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/situacion/laboral")
 */
class SituacionLaboralController extends AbstractController
{
    /**
     * @Route("/", name="situacion_laboral_index", methods={"GET"})
     */
    public function index(SituacionLaboralRepository $situacionLaboralRepository): Response
    {
        return $this->render('situacion_laboral/index.html.twig', [
            'situacion_laborals' => $situacionLaboralRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="situacion_laboral_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $situacionLaboral = new SituacionLaboral();
        $form = $this->createForm(SituacionLaboralType::class, $situacionLaboral);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($situacionLaboral);
            $entityManager->flush();

            return $this->redirectToRoute('situacion_laboral_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('situacion_laboral/new.html.twig', [
            'situacion_laboral' => $situacionLaboral,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="situacion_laboral_show", methods={"GET"})
     */
    public function show(SituacionLaboral $situacionLaboral): Response
    {
        return $this->render('situacion_laboral/show.html.twig', [
            'situacion_laboral' => $situacionLaboral,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="situacion_laboral_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SituacionLaboral $situacionLaboral): Response
    {
        $form = $this->createForm(SituacionLaboralType::class, $situacionLaboral);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('situacion_laboral_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('situacion_laboral/edit.html.twig', [
            'situacion_laboral' => $situacionLaboral,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="situacion_laboral_delete", methods={"POST"})
     */
    public function delete(Request $request, SituacionLaboral $situacionLaboral): Response
    {
        if ($this->isCsrfTokenValid('delete'.$situacionLaboral->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($situacionLaboral);
            $entityManager->flush();
        }

        return $this->redirectToRoute('situacion_laboral_index', [], Response::HTTP_SEE_OTHER);
    }
}
