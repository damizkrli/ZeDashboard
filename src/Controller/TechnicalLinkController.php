<?php

namespace App\Controller;

use App\Entity\TechnicalLink;
use App\Form\TechnicalLinkType;
use App\Repository\TechnicalLinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/technical/link')]
class TechnicalLinkController extends AbstractController
{
    private TechnicalLinkRepository $technicalLinkRepository;

    public function __construct(TechnicalLinkRepository $technicalLinkRepository)
    {
        $this->technicalLinkRepository = $technicalLinkRepository;
    }


}
