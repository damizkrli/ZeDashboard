<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/parameters')]
class ParameterController extends AbstractController
{
    public function __construct()
    {
        // TODO : mettre les repo de company et platform
    }

    public function index(): Response
    {
        return $this->render('parameter.html.twig', [
            // TODO : mettre les vues de add/edit/delete/show company et platform
        ]);
    }
}