<?php

namespace App\Controller;

use App\Entity\EntRecepDenuncia;
use App\Form\EntRecepDenunciaType;
use App\Repository\EntRecepDenunciaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ent/recep/denuncia")
 */
class EntRecepDenunciaController extends AbstractController
{
    /**
     * @Route("/", name="ent_recep_denuncia_index", methods={"GET"})
     */
    public function index(EntRecepDenunciaRepository $entRecepDenunciaRepository): Response
    {
        return $this->render('ent_recep_denuncia/index.html.twig', [
            'ent_recep_denuncias' => $entRecepDenunciaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ent_recep_denuncia_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entRecepDenuncium = new EntRecepDenuncia();
        $form = $this->createForm(EntRecepDenunciaType::class, $entRecepDenuncium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($entRecepDenuncium);
            $entityManager->flush();

            return $this->redirectToRoute('ent_recep_denuncia_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ent_recep_denuncia/new.html.twig', [
            'ent_recep_denuncium' => $entRecepDenuncium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ent_recep_denuncia_show", methods={"GET"})
     */
    public function show(EntRecepDenuncia $entRecepDenuncium): Response
    {
        return $this->render('ent_recep_denuncia/show.html.twig', [
            'ent_recep_denuncium' => $entRecepDenuncium,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ent_recep_denuncia_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, EntRecepDenuncia $entRecepDenuncium, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EntRecepDenunciaType::class, $entRecepDenuncium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('ent_recep_denuncia_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ent_recep_denuncia/edit.html.twig', [
            'ent_recep_denuncium' => $entRecepDenuncium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ent_recep_denuncia_delete", methods={"POST"})
     */
    public function delete(Request $request, EntRecepDenuncia $entRecepDenuncium, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entRecepDenuncium->getId(), $request->request->get('_token'))) {
            $entityManager->remove($entRecepDenuncium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ent_recep_denuncia_index', [], Response::HTTP_SEE_OTHER);
    }
}
