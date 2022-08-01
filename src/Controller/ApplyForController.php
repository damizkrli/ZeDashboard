<?php

namespace App\Controller;

use App\Entity\ApplyFor;
use App\Form\ApplyForType;
use App\Repository\ApplyForRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class ApplyForController extends AbstractController
{
    #[Route('/', name: 'app_apply_for_index', methods: ['GET'])]
    public function index(ApplyForRepository $applyForRepository): Response
    {
        return $this->render('apply_for/index.html.twig', [
            'apply_for' => $applyForRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_apply_for_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ApplyForRepository $applyForRepository): Response
    {
        $applyFor = new ApplyFor();
        $form = $this->createForm(ApplyForType::class, $applyFor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $applyForRepository->add($applyFor, true);

            return $this->redirectToRoute('app_apply_for_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('apply_for/new.html.twig', [
            'apply_for' => $applyFor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_apply_for_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ApplyFor $applyFor, ApplyForRepository $applyForRepository): Response
    {
        $form = $this->createForm(ApplyForType::class, $applyFor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $applyForRepository->add($applyFor, true);

            return $this->redirectToRoute('app_apply_for_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('apply_for/edit.html.twig', [
            'apply_for' => $applyFor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_apply_for_delete', methods: ['POST'])]
    public function delete(Request $request, ApplyFor $applyFor, ApplyForRepository $applyForRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$applyFor->getId(), $request->request->get('_token'))) {
            $applyForRepository->remove($applyFor, true);
        }

        return $this->redirectToRoute('app_apply_for_index', [], Response::HTTP_SEE_OTHER);
    }
}
