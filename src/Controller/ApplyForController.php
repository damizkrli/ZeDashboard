<?php

namespace App\Controller;

use App\Entity\ApplyFor;
use App\Entity\ProfessionalLink;
use App\Form\ApplyForType;
use App\Form\ProfessionalLinkType;
use App\Repository\ApplyForRepository;
use App\Repository\MotivationRepository;
use App\Repository\PlatformRepository;
use App\Repository\ProfessionalLinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class ApplyForController extends AbstractController
{
    private ApplyForRepository $applyForRepository;
    private MotivationRepository $motivationRepository;
    private PlatformRepository $platformRepository;
    private ProfessionalLinkRepository $professionalLinkRepository;

    public function __construct(
        ApplyForRepository $applyForRepository,
        MotivationRepository $motivationRepository,
        PlatformRepository $platformRepository,
        ProfessionalLinkRepository $professionalLinkRepository
    )
    {
        $this->applyForRepository = $applyForRepository;
        $this->motivationRepository = $motivationRepository;
        $this->platformRepository = $platformRepository;
        $this->professionalLinkRepository = $professionalLinkRepository;
    }

    #[Route('/', name: 'app_apply_for_index', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('apply_for/index.html.twig', [
            'apply_for' => $this->applyForRepository->findAll(),
            'motivation' => $this->motivationRepository->findAll(),
            'platform' => $this->platformRepository->findAll(),
            'proLink' => $this->professionalLinkRepository->findAll(),
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

            return $this->redirectToRoute('app_apply_for_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('apply_for/new.html.twig', [
            'apply_for' => $applyFor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_apply_for_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ApplyFor $applyFor): Response
    {
        $form = $this->createForm(ApplyForType::class, $applyFor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->applyForRepository->add($applyFor, true);

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
        if ($this->isCsrfTokenValid('delete'.$applyFor->getId(), $request->request->get('_token'))) {
            $this->applyForRepository->remove($applyFor, true);
        }

        return $this->redirectToRoute('app_apply_for_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/add/link', name: 'app_add_professional_link', methods: ['GET', 'POST'])]
    public function newProfessionalLink(Request $request): Response
    {
        $proLink = new ProfessionalLink();
        $form = $this->createForm(ProfessionalLinkType::class, $proLink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $this->professionalLinkRepository->add($proLink, true);

            return $this->redirectToRoute('app_apply_for_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('link/professional/new.html.twig', [
            'proLink' => $proLink,
            'form' => $form,
        ]);
    }
}
