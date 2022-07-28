<?php

namespace App\Controller;

use App\Entity\ApplyFor;
use App\Form\ApplyForType;
use App\Repository\ApplyForRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApplyForController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ApplyForRepository $applyForRepository;

    public function __construct(EntityManagerInterface $entityManager, ApplyForRepository $applyForRepository)
    {
        $this->entityManager = $entityManager;
        $this->applyForRepository = $applyForRepository;
    }

    #[Route('/', name: 'app_apply_for')]
    public function index(Request $request): Response
    {
        $applyFor = $this->applyForRepository->findAll();

        $form = $this->createForm(ApplyForType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->entityManager->persist($data);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_apply_for');
        }

        return $this->render('apply_for/index.html.twig', [
            'applyFor' => $applyFor,
            'form' => $form->createView(),
        ]);
    }
}
