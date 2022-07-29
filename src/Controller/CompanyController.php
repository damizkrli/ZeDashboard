<?php

namespace App\Controller;

use App\Form\CompanyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/add/company', name: 'app_company')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(CompanyType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $this->entityManager->persist($data);
            $this->entityManager->flush();
            $this->addFlash('success', 'L\'entreprise à été ajoutée.');

            return $this->redirectToRoute('app_company');
        }

        return $this->render('company/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
