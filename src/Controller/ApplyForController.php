<?php

namespace App\Controller;

use App\Entity\ApplyFor;
use App\Entity\Company;
use App\Entity\Platform;
use App\Entity\ProfessionalLink;
use App\Form\ApplyForType;
use App\Form\ProfessionalLinkType;
use App\Repository\ApplyForRepository;
use App\Repository\CompanyRepository;
use App\Repository\NoteRepository;
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
    private NoteRepository $motivationRepository;
    private ProfessionalLinkRepository $professionalLinkRepository;
    private CompanyRepository $companyRepository;
    private PlatformRepository $platformRepository;

    public function __construct(
        ApplyForRepository         $applyForRepository,
        NoteRepository             $motivationRepository,
        ProfessionalLinkRepository $professionalLinkRepository,
        CompanyRepository $companyRepository,
        PlatformRepository $platformRepository,
    )
    {
        $this->applyForRepository = $applyForRepository;
        $this->motivationRepository = $motivationRepository;
        $this->professionalLinkRepository = $professionalLinkRepository;
        $this->companyRepository = $companyRepository;
        $this->platformRepository = $platformRepository;
    }

    #[Route('/', name: 'app_apply_for_index', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('apply_for/index.html.twig', [
            'apply_for' => $this->applyForRepository->findAll(),
            'note' => $this->motivationRepository->findAll(),
            'proLink' => $this->professionalLinkRepository->findAll(),
            'company' => $this->companyRepository->findAll(),
            'platform' => $this->platformRepository->findAll()
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

    #[Route('/index/link/pro', name: 'app_index_pro_link', methods: ['GET', 'POST'])]
    public function indexProfessionalLink(): Response
    {
        $links = $this->professionalLinkRepository->findAll();

        return $this->render('link/professional/index.html.twig', [
            'links' => $links,
        ]);
    }

    #[Route('/add/professional/link', name: 'app_add_professional_link', methods: ['GET', 'POST'])]
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

    #[Route('/{id}/edit/link/professional', name: 'app_edit_professional_link', methods: ['GET', 'POST'])]
    public function editProfessionalLink(Request $request, ProfessionalLink $professionalLink): Response
    {
        $form = $this->createForm(ProfessionalLinkType::class, $professionalLink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->professionalLinkRepository->add($professionalLink, true);

            return $this->redirectToRoute('app_index_pro_link', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('link/professional/edit.html.twig', [
            'professionalLink' => $professionalLink,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/pro/link', name: 'app_delete_pro_link', methods: ['POST'])]
    public function deleteProfessionalLink(Request $request, ProfessionalLink $professionalLink): Response
    {
        if ($this->isCsrfTokenValid('delete'.$professionalLink->getId(), $request->request->get('_token'))) {
            $this->professionalLinkRepository->remove($professionalLink, true);
        }

        return $this->redirectToRoute('app_index_pro_link', [], Response::HTTP_SEE_OTHER);
    }
}
