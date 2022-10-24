<?php

namespace App\Controller;

use App\Entity\ApplyFor;
use App\Entity\PersonalLink;
use App\Entity\ProfessionalLink;
use App\Entity\TechnicalLink;
use App\Form\ApplyForType;
use App\Form\PersonalLinkType;
use App\Form\ProfessionalLinkType;
use App\Form\TechnicalLinkType;
use App\Repository\ApplyForRepository;
use App\Repository\CompanyRepository;
use App\Repository\PersonalLinkRepository;
use App\Repository\ProfessionalLinkRepository;
use App\Repository\TechnicalLinkRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApplyForController extends AbstractController
{
    private ApplyForRepository $applyForRepository;
    private ProfessionalLinkRepository $professionalLinkRepository;
    private TechnicalLinkRepository $technicalLinkRepository;
    private PersonalLinkRepository $personalLinkRepository;
    private FlashyNotifier $flashyNotifier;

    public function __construct(
        ApplyForRepository         $applyForRepository,
        ProfessionalLinkRepository $professionalLinkRepository,
        TechnicalLinkRepository $technicalLinkRepository,
        PersonalLinkRepository $personalLinkRepository,
        FlashyNotifier $flashyNotifier,
    )
    {
        $this->applyForRepository = $applyForRepository;
        $this->professionalLinkRepository = $professionalLinkRepository;
        $this->technicalLinkRepository = $technicalLinkRepository;
        $this->personalLinkRepository = $personalLinkRepository;
        $this->flashyNotifier = $flashyNotifier;
    }

/* -------------------------------- APPLY FOR ------------------------------------------------ */
    #[Route('/apply/', name: 'app_apply_for_index', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        //chercher le numéro de page dans l'url
        $page = $request->query->getInt('page', 1);

        $applies = $this->applyForRepository->findApplyForPaginated($page, 10);

        return $this->render('apply_for/index.html.twig', [
            'apply_for' => $applies,
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
            $this->flashyNotifier->info('Votre candidature pour ' . $applyFor->getCompany() . ' à été transmise.');

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
        // TODO : date retour n'est pas récupérée lors de l'édition
        $form = $this->createForm(ApplyForType::class, $applyFor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->applyForRepository->add($applyFor, true);
            $this->flashyNotifier->info( 'Votre candidature pour ' . $applyFor->getCompany() . ' à été modifiée.');

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
            $this->flashyNotifier->warning('Votre candidature pour ' . $applyFor->getCompany() . ' à été supprimée.');
        }

        return $this->redirectToRoute('app_apply_for_index', [], Response::HTTP_SEE_OTHER);
    }

/* -------------------------------- LINKS ------------------------------------------------ */

    #[Route('/links/index', name: 'app_link_index', methods: ['GET', 'POST'])]
    public function linksIndex(): Response
    {
        $linksPro = $this->professionalLinkRepository->findAll();
        $linksTech = $this->technicalLinkRepository->findAll();
        $linksPerso = $this->personalLinkRepository->findAll();

        return $this->render('link/links.html.twig', [
            'linksPro' => $linksPro,
            'linksPerso' => $linksPerso,
            'linksTech' => $linksTech
        ]);
    }

/* -------------------------------- PROFESSIONAL LINK ------------------------------------------------ */
    #[Route('/index/link/pro', name: 'app_index_pro_link', methods: ['GET', 'POST'])]
    public function indexProfessionalLink(): Response
    {
        $pros = $this->professionalLinkRepository->findAll();

        return $this->render('link/professional/index.html.twig', [
            'pros' => $pros,
        ]);
    }

    #[Route('/add/link/pro', name: 'app_add_pro_link', methods: ['GET', 'POST'])]
    public function newProfessionalLink(Request $request): Response
    {
        $proLink = new ProfessionalLink();
        $form = $this->createForm(ProfessionalLinkType::class, $proLink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $this->professionalLinkRepository->add($proLink, true);

            return $this->redirectToRoute('app_index_pro_link', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('link/professional/new.html.twig', [
            'proLink' => $proLink,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit/link/pro', name: 'app_edit_professional_link', methods: ['GET', 'POST'])]
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

/* -------------------------------- TECHNICAL LINK ------------------------------------------------ */
    #[Route('/index/link/tech', name: 'app_index_tech_link', methods: ['GET'])]
    public function indexTechnicalLink(): Response
    {
        $techs = $this->technicalLinkRepository->findAll();

        return $this->render('link/technical/index.html.twig', [
            'techs' => $techs,
        ]);
    }

    #[Route('/add/link/tech', name: 'app_add_tech_link', methods: ['GET', 'POST'])]
    public function newTechnicalLink(Request $request, TechnicalLinkRepository $technicalLinkRepository): Response
    {
        $technicalLink = new TechnicalLink();
        $form = $this->createForm(TechnicalLinkType::class, $technicalLink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $technicalLinkRepository->save($technicalLink, true);

            return $this->redirectToRoute('app_index_tech_link', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('link/technical/new.html.twig', [
            'technical' => $technicalLink,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit/link/tech', name: 'app_edit_tech_link', methods: ['GET', 'POST'])]
    public function editTechnicalLink(Request $request, TechnicalLink $technicalLink, TechnicalLinkRepository $technicalLinkRepository): Response
    {
        $form = $this->createForm(TechnicalLinkType::class, $technicalLink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $technicalLinkRepository->save($technicalLink, true);

            return $this->redirectToRoute('app_index_tech_link', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('link/technical/edit.html.twig', [
            'technical' => $technicalLink,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/tech/link', name: 'app_delete_tech_link', methods: ['POST'])]
    public function deleteTechnicalLink(Request $request, TechnicalLink $technicalLink, TechnicalLinkRepository $technicalLinkRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$technicalLink->getId(), $request->request->get('_token'))) {
            $technicalLinkRepository->remove($technicalLink, true);
        }

        return $this->redirectToRoute('app_index_tech_link', [], Response::HTTP_SEE_OTHER);
    }

/* -------------------------------- PERSONAL LINK ------------------------------------------------ */
    #[Route('/index/link/perso', name: 'app_index_perso_link', methods: ['GET'])]
    public function indexPersonalLink(): Response
    {
        $persos = $this->personalLinkRepository->findAll();

        return $this->render('link/personal/index.html.twig', [
            'persos' => $persos,
        ]);
    }

    #[Route('/add/link/perso', name: 'app_add_perso_link', methods: ['GET', 'POST'])]
    public function addPersonalLink(Request $request, PersonalLinkRepository $personalLinkRepository): Response
    {
        $personalLink = new PersonalLink();
        $form = $this->createForm(PersonalLinkType::class, $personalLink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personalLinkRepository->save($personalLink, true);

            return $this->redirectToRoute('app_index_perso_link', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('link/personal/new.html.twig', [
            'persoLink' => $personalLink,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit/link/perso', name: 'app_edit_perso_link', methods: ['GET', 'POST'])]
    public function editPersonalLink(Request $request, PersonalLink $personalLink): Response
    {
        $form = $this->createForm(PersonalLinkType::class, $personalLink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->personalLinkRepository->save($personalLink, true);

            return $this->redirectToRoute('app_index_perso_link', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('link/personal/edit.html.twig', [
            'personalLink' => $personalLink,
            'form' => $form
        ]);
    }

    #[Route('/{id}/perso/link', name: 'app_delete_perso_link', methods: ['GET', 'POST'])]
    public function deletePersonalLink(Request $request, PersonalLink $personalLink, PersonalLinkRepository $personalLinkRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personalLink->getId(), $request->request->get('_token'))) {
            $personalLinkRepository->remove($personalLink, true);
        }

        return $this->redirectToRoute('app_index_perso_link', [], Response::HTTP_SEE_OTHER);
    }

}
