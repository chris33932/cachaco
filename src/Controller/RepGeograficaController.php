<?php

namespace App\Controller;

use App\Entity\RepGeografica;
use App\Form\RepGeograficaType;
use App\Repository\RepGeograficaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rep/geografica")
 */
class RepGeograficaController extends AbstractController
{
    /**
     * @Route("/", name="rep_geografica_index", methods={"GET"})
     */
    public function index(RepGeograficaRepository $repGeograficaRepository): Response
    {
        return $this->render('rep_geografica/index.html.twig', [
            'rep_geograficas' => $repGeograficaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="rep_geografica_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $repGeografica = new RepGeografica();
        $form = $this->createForm(RepGeograficaType::class, $repGeografica);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($repGeografica);
            $entityManager->flush();

            return $this->redirectToRoute('rep_geografica_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rep_geografica/new.html.twig', [
            'rep_geografica' => $repGeografica,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rep_geografica_show", methods={"GET"})
     */
    public function show(RepGeografica $repGeografica): Response
    {
        return $this->render('rep_geografica/show.html.twig', [
            'rep_geografica' => $repGeografica,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rep_geografica_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, RepGeografica $repGeografica): Response
    {
        $form = $this->createForm(RepGeograficaType::class, $repGeografica);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rep_geografica_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rep_geografica/edit.html.twig', [
            'rep_geografica' => $repGeografica,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rep_geografica_delete", methods={"POST"})
     */
    public function delete(Request $request, RepGeografica $repGeografica): Response
    {
        if ($this->isCsrfTokenValid('delete'.$repGeografica->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($repGeografica);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rep_geografica_index', [], Response::HTTP_SEE_OTHER);
    }
}
