<?php

namespace App\Controller;

use App\Entity\Platform;
use App\Form\PlatformType;
use App\Repository\PlatformRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/platform')]
class PlatformController extends AbstractController
{

    #[Route('/index', name: 'app_platform_index', methods: ['GET'])]
    public function index(PlatformRepository $platformRepository): Response
    {
        return $this->render('platform/index.html.twig', [
            'platforms' => $platformRepository->findBy([], ['id' => 'DESC']),
        ]);
    }

    #[Route('/new', name: 'app_platform_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PlatformRepository $platformRepository): Response
    {
        $platform = new Platform();
        $form = $this->createForm(PlatformType::class, $platform);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $platformRepository->save($platform, true);
//            $this->flashyNotifier->info('La plateforme ' . $platform->getName() . ' à été ajoutée.');

            return $this->redirectToRoute('app_apply_for_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('platform/new.html.twig', [
            'platform' => $platform,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_platform_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Platform $platform, PlatformRepository $platformRepository): Response
    {
        $form = $this->createForm(PlatformType::class, $platform);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $platformRepository->save($platform, true);
//            $this->flashyNotifier->info('La plateforme ' . $platform->getName() . ' à été modifiée.');

            return $this->redirectToRoute('app_platform_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('platform/edit.html.twig', [
            'platform' => $platform,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_platform_delete', methods: ['POST'])]
    public function delete(Request $request, Platform $platform, PlatformRepository $platformRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$platform->getId(), $request->request->get('_token'))) {
            $platformRepository->remove($platform, true);
//            $this->flashyNotifier->warning('La plateforme ' . $platform->getName() . ' à été supprimé.');
        }

        return $this->redirectToRoute('app_platform_index', [], Response::HTTP_SEE_OTHER);
    }
}
