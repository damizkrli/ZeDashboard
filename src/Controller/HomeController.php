<?php

namespace App\Controller;

use App\Repository\ApplyForRepository;
use App\Services\CalculateRules;
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
    public function index(CalculateRules $calculateRules): Response
    {
        $totalApplies = $calculateRules->calculateTotalApplies();
        $sentApplies = $calculateRules->calculateSentApplies();
        $noResponseApplies = $calculateRules->calculateNoResponseApplies();
        $interviewApplies = $calculateRules->calculateInterviewApplies();
        $refusedApplies = $calculateRules->calculateRefusedApplies();
        $numCall = $calculateRules->calculateNumberOfCall();
        $acceptedApplies = $calculateRules->calculateAcceptedApplies();

        return $this->render('home/index.html.twig', [
            'apply_for' => $this->applyForRepository->findBy([], ['jobTitle' => 'DESC']),
            'totalApplies' => $totalApplies,
            'sentApplies' => $sentApplies,
            'noResponseApplies' => $noResponseApplies,
            'interviewApplies' => $interviewApplies,
            'refusedApplies' => $refusedApplies,
            'numCall' => $numCall,
            'acceptedApplies' => $acceptedApplies,
            'calculatePercentRefusedApplies' => $calculateRules->calculatePercentRefusedApplies($refusedApplies, $totalApplies),
            'calculatePercentSentApplies' => $calculateRules->calculatePercentSentApplies($sentApplies, $totalApplies),
            'calculatePercentResponseApplies' => $calculateRules->calculatePercentResponseApplies($noResponseApplies, $totalApplies),
            'calculatePercentInterviewApplies' => $calculateRules->calculatePercentInterviewApplies($interviewApplies, $totalApplies),
            'calculatePercentNumberOfCall' => $calculateRules->calculatePercentNumberOfCall($numCall, $totalApplies),
            'calculatePercentAcceptedApplies' => $calculateRules->calculatePercentAcceptedApplies($acceptedApplies, $totalApplies),
        ]);
        }
    }