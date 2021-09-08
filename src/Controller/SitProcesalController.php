<?php

namespace App\Controller;

use App\Entity\SitProcesal;
use App\Form\SitProcesalType;
use App\Repository\SitProcesalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sit/procesal")
 */
class SitProcesalController extends AbstractController
{
    /**
     * @Route("/", name="sit_procesal_index", methods={"GET"})
     */
    public function index(SitProcesalRepository $sitProcesalRepository): Response
    {
        return $this->render('sit_procesal/index.html.twig', [
            'sit_procesals' => $sitProcesalRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sit_procesal_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sitProcesal = new SitProcesal();
        $form = $this->createForm(SitProcesalType::class, $sitProcesal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sitProcesal);
            $entityManager->flush();

            return $this->redirectToRoute('sit_procesal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sit_procesal/new.html.twig', [
            'sit_procesal' => $sitProcesal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sit_procesal_show", methods={"GET"})
     */
    public function show(SitProcesal $sitProcesal): Response
    {
        return $this->render('sit_procesal/show.html.twig', [
            'sit_procesal' => $sitProcesal,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sit_procesal_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SitProcesal $sitProcesal): Response
    {
        $form = $this->createForm(SitProcesalType::class, $sitProcesal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sit_procesal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sit_procesal/edit.html.twig', [
            'sit_procesal' => $sitProcesal,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sit_procesal_delete", methods={"POST"})
     */
    public function delete(Request $request, SitProcesal $sitProcesal): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sitProcesal->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sitProcesal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sit_procesal_index', [], Response::HTTP_SEE_OTHER);
    }
}
