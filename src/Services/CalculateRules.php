<?php

namespace App\Services;

use App\Repository\ApplyForRepository;
use App\Repository\ContactRepository;

class CalculateRules
{
    private ApplyForRepository $applyForRepository;
    private ContactRepository $contactRepository;

    public function __construct(ApplyForRepository $applyForRepository, ContactRepository $contactRepository)
    {
        $this->applyForRepository = $applyForRepository;
        $this->contactRepository = $contactRepository;
    }

    public function calculateTotalApplies(): int
    {
        $totalApplies = $this->applyForRepository->findAll();

        return count($totalApplies);
    }

    public function calculateSentApplies():int
    {
        $sentApplies = $this->applyForRepository->findBy(['status' => 'Envoyée']);

        return count($sentApplies);
    }

    public function calculatePercentSentApplies($refusedApplies, $totalApplies): int
    {
        $total = 0;

        // si aucunes données dans les candidatures
        if ($totalApplies != 0) {
            $total = 100 * ($refusedApplies / $totalApplies);
        }

        return $total;

    }

    public function calculateNoResponseApplies(): int
    {
        $noResponseApplies = $this->applyForRepository->findBy(['status' => 'Ignorée']);

        return count($noResponseApplies);
    }

    public function calculatePercentResponseApplies($refusedApplies, $totalApplies): int
    {
        $total = 0;

        // si aucunes données dans les candidatures
        if ($totalApplies != 0) {
            $total = 100 * ($refusedApplies / $totalApplies);
        }

        return $total;

    }

    public function calculateInterviewApplies(): int
    {
        $interviewApplies = $this->applyForRepository->findBy(['status' => 'Entretien']);

        return count($interviewApplies);
    }

    public function calculatePercentInterviewApplies($refusedApplies, $totalApplies): int
    {
        $total = 0;

        // si aucunes données dans les candidatures
        if ($totalApplies != 0) {
            $total = 100 * ($refusedApplies / $totalApplies);
        }

        return $total;

    }

    public function calculateRefusedApplies(): int
    {
        $refusedApplies = $this->applyForRepository->findBy(['status' => 'Refusée']);

        return count($refusedApplies);
    }


    public function calculateNumberOfCall(): int
    {
        $numCall = $this->applyForRepository->findBy(['status' => 'Appel']);

        return count($this->applyForRepository->findBy(['status' => 'Appel']));
    }

    public function calculatePercentNumberOfCall($refusedApplies, $totalApplies): int
    {
        $total = 0;

        // si aucunes données dans les candidatures
        if ($totalApplies != 0) {
            $total = 100 * ($refusedApplies / $totalApplies);
        }

        return $total;

    }

    public function calculateAcceptedApplies(): int
    {
        $accpetedApplies = $this->applyForRepository->findBy(['status' => 'Acceptée']);

        return count($accpetedApplies);
    }

    public function calculatePercentAcceptedApplies($acceptedApplies, $totalApplies): int
    {
        $total = 0;

        // si aucunes données dans les candidatures
        if ($totalApplies != 0) {
            $total = 100 * ($acceptedApplies / $totalApplies);
        }

        return $total;

    }

    public function calculatePercentRefusedApplies($refusedApplies, $totalApplies): int
    {
        $total = 0;

        // si aucunes données dans les candidatures
        if ($totalApplies != 0) {
            $total = 100 * ($refusedApplies / $totalApplies);
        }

        return $total;

    }

    public function totalContact(): int
    {
        $totalContact = $this->contactRepository->findAll();

        return count($totalContact);
    }
}