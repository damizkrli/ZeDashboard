<?php

namespace App\Controller;

use App\Repository\ApplyForRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class HomeController extends AbstractController
{
    private ApplyForRepository $applyForRepository;

    public function __construct(
        ApplyForRepository         $applyForRepository,
    )
    {
        $this->applyForRepository = $applyForRepository;
    }

    #[Route('/', name: 'app_index_home', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        $totalApplies = count($this->applyForRepository->findAll());
        $sentApplies = count($this->applyForRepository->findBy(['status' => 'Transmise']));
        $noResponseApplies = count($this->applyForRepository->findBy(['status' => 'Sans Réponse']));
        $interviewApplies = count($this->applyForRepository->findBy(['status' => 'Entretien']));
        $refusedApplies = count($this->applyForRepository->findBy(['status' => 'Refusée']));
        $numCall = count($this->applyForRepository->findBy(['status' => 'Appel']));
        $acceptedApplies = count($this->applyForRepository->findBy(['status' => 'Acceptée']));

        return $this->render('home/index.html.twig', [
            'apply_for' => $this->applyForRepository->findAll(),
            'totalApplies' => $totalApplies,
            'sentApplies' => $sentApplies,
            'noResponseApplies' => $noResponseApplies,
            'interviewApplies' => $interviewApplies,
            'refusedApplies' => $refusedApplies,
            'numCall' => $numCall,
            'acceptedApplies' => $acceptedApplies
        ]);
        }
    }