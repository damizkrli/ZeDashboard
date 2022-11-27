<?php

namespace App\Controller;

use App\Entity\ApplyFor;
use App\Form\ApplyForType;
use App\Repository\ApplyForRepository;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/candidacy')]
class ApplyForController extends AbstractController
{
    private ApplyForRepository $applyForRepository;
    private ContactRepository $contactRepository;

    public function __construct(ApplyForRepository $applyForRepository, ContactRepository $contactRepository)
    {
        $this->applyForRepository = $applyForRepository;
        $this->contactRepository = $contactRepository;
    }

    #[Route('/index', name: 'app_apply_for_index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $applyFor = $this->applyForRepository->findBy([], ['sent' => 'DESC']);

        $contacts = $this->contactRepository->findAll();

        return $this->render('apply_for/index.html.twig', [
            'apply_for' => $applyFor,
            'contacts' => $contacts,
        ]);
    }

    #[Route('/new', name: 'app_apply_for_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $applyFor = new ApplyFor();
        $form = $this->createForm(ApplyForType::class, $applyFor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->applyForRepository->add($applyFor, true);
            $this->addFlash(
                'success',
                'Votre candidature à été ajouté avec succès.'
            );

            return $this->redirectToRoute('app_apply_for_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('apply_for/new.html.twig', [
            'apply_for' => $applyFor,
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'app_apply_for_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ApplyFor $applyFor): Response
    {
        $form = $this->createForm(ApplyForType::class, $applyFor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->applyForRepository->add($applyFor, true);
            $this->addFlash(
                'info',
                'Votre candidature à été modifiée avec succès.'
            );

            return $this->redirectToRoute('app_apply_for_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('apply_for/edit.html.twig', [
            'apply_for' => $applyFor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_apply_for_delete', methods: ['POST'])]
    public function delete(Request $request, ApplyFor $applyFor): Response
    {
        if ($this->isCsrfTokenValid('delete' . $applyFor->getId(), $request->request->get('_token'))) {
            $this->applyForRepository->remove($applyFor, true);
            $this->addFlash(
                'danger',
                'Votre candidature à été supprimée avec succès.'
            );
        }

        return $this->redirectToRoute('app_apply_for_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_apply_for_show', methods: ['GET'])]
    public function show(ApplyFor $applyFor): Response
    {
        return $this->render('apply_for/show.html.twig', [
            'applyFor' => $applyFor,
        ]);
    }

}
