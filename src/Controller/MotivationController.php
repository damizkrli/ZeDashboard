<?php

namespace App\Controller;

use App\Entity\Motivation;
use App\Form\MotivationType;
use App\Repository\MotivationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/motivation')]
class MotivationController extends AbstractController
{
    #[Route('/', name: 'app_motivation_index', methods: ['GET'])]
    public function index(MotivationRepository $motivationRepository): Response
    {
        return $this->render('motivation/index.html.twig', [
            'motivations' => $motivationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_motivation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MotivationRepository $motivationRepository): Response
    {
        $motivation = new Motivation();
        $form = $this->createForm(MotivationType::class, $motivation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $motivationRepository->add($motivation, true);

            return $this->redirectToRoute('app_motivation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('motivation/new.html.twig', [
            'motivation' => $motivation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_motivation_show', methods: ['GET'])]
    public function show(Motivation $motivation): Response
    {
        return $this->render('motivation/index.html.twig', [
            'motivation' => $motivation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_motivation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Motivation $motivation, MotivationRepository $motivationRepository): Response
    {
        $form = $this->createForm(MotivationType::class, $motivation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $motivationRepository->add($motivation, true);

            return $this->redirectToRoute('app_motivation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('motivation/edit.html.twig', [
            'motivation' => $motivation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_motivation_delete', methods: ['POST'])]
    public function delete(Request $request, Motivation $motivation, MotivationRepository $motivationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$motivation->getId(), $request->request->get('_token'))) {
            $motivationRepository->remove($motivation, true);
        }

        return $this->redirectToRoute('app_motivation_index', [], Response::HTTP_SEE_OTHER);
    }
}
