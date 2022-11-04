<?php

namespace App\Controller;

use App\Entity\Link;
use App\Form\LinkType;
use App\Repository\LinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LinkController extends AbstractController
{

    private LinkRepository $linkRepository;

    public function __construct(LinkRepository $linkRepository)
    {
        $this->linkRepository = $linkRepository;
    }

    #[Route('/links/index', name: 'app_link_index', methods: ['GET', 'POST'])]
    public function indexLink(): Response
    {
        $links = $this->linkRepository->findBy([], ['id' => 'DESC']);

        return $this->render('link/index.html.twig', [
            'links' => $links,
        ]);
    }

    #[Route('/add/link', name: 'app_add_link', methods: ['GET', 'POST'])]
    public function newLink(Request $request): Response
    {
        $links = new Link();
        $form = $this->createForm(LinkType::class, $links);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $this->linkRepository->save($links, true);

            return $this->redirectToRoute('app_link_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('link/new.html.twig', [
            'links' => $links,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit/link/', name: 'app_edit_link', methods: ['GET', 'POST'])]
    public function editLink(Request $request, Link $link): Response
    {
        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->linkRepository->save($link, true);

            return $this->redirectToRoute('app_link_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('link/edit.html.twig', [
            'link' => $link,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_delete_link', methods: ['POST'])]
    public function deleteLink(Request $request, Link $link): Response
    {
        if ($this->isCsrfTokenValid('delete'.$link->getId(), $request->request->get('_token'))) {
            $this->linkRepository->remove($link, true);
        }

        return $this->redirectToRoute('app_link_index', [], Response::HTTP_SEE_OTHER);
    }
}
