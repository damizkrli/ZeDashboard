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
        return $this->render('home/index.html.twig', [
            'apply_for' => $this->applyForRepository->findAll(),
        ]);
        }
    }