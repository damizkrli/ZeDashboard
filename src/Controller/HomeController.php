<?php

namespace App\Controller;

use App\Entity\ApplyFor;
use App\Repository\ApplyForRepository;
use App\Repository\CompanyRepository;
use App\Repository\NoteRepository;
use App\Repository\PersonalLinkRepository;
use App\Repository\PlatformRepository;
use App\Repository\ProfessionalLinkRepository;
use App\Repository\TechnicalLinkRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class HomeController extends AbstractController
{
    private ApplyForRepository $applyForRepository;
    private NoteRepository $noteRepository;
    private ProfessionalLinkRepository $professionalLinkRepository;
    private CompanyRepository $companyRepository;
    private PlatformRepository $platformRepository;
    private TechnicalLinkRepository $technicalLinkRepository;
    private PersonalLinkRepository $personalLinkRepository;

    public function __construct(
        ApplyForRepository         $applyForRepository,
        NoteRepository             $noteRepository,
        ProfessionalLinkRepository $professionalLinkRepository,
        CompanyRepository $companyRepository,
        PlatformRepository $platformRepository,
        TechnicalLinkRepository $technicalLinkRepository,
        PersonalLinkRepository $personalLinkRepository,
    )
    {
        $this->applyForRepository = $applyForRepository;
        $this->noteRepository = $noteRepository;
        $this->professionalLinkRepository = $professionalLinkRepository;
        $this->companyRepository = $companyRepository;
        $this->platformRepository = $platformRepository;
        $this->technicalLinkRepository = $technicalLinkRepository;
        $this->personalLinkRepository = $personalLinkRepository;
    }

    #[Route('/', name: 'app_index_home', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'apply_for' => $this->applyForRepository->findAll(),
            'note' => $this->noteRepository->findAll(),
            'proLink' => $this->professionalLinkRepository->findAll(),
            'company' => $this->companyRepository->findAll(),
            'platform' => $this->platformRepository->findAll(),
            'techLink' => $this->technicalLinkRepository->findAll(),
            'persoLink' => $this->personalLinkRepository->findAll(),
        ]);
        }
    }