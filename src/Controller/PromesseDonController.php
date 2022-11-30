<?php

namespace App\Controller;

use App\Entity\PromesseDon;
use App\Form\PromesseDonType;
use App\Repository\PromesseDonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/promesse/don')]
class PromesseDonController extends AbstractController
{
    #[Route('/', name: 'app_promesse_don_index', methods: ['GET'])]
    public function index(PromesseDonRepository $promesseDonRepository): Response
    {
        return $this->render('promesse_don/index.html.twig', [
            'promesse_dons' => $promesseDonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_promesse_don_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PromesseDonRepository $promesseDonRepository): Response
    {
        $promesseDon = new PromesseDon();
        $form = $this->createForm(PromesseDonType::class, $promesseDon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $promesseDonRepository->save($promesseDon, true);

            return $this->redirectToRoute('app_promesse_don_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promesse_don/new.html.twig', [
            'promesse_don' => $promesseDon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_promesse_don_show', methods: ['GET'])]
    public function show(PromesseDon $promesseDon): Response
    {
        return $this->render('promesse_don/show.html.twig', [
            'promesse_don' => $promesseDon,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_promesse_don_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PromesseDon $promesseDon, PromesseDonRepository $promesseDonRepository): Response
    {
        $form = $this->createForm(PromesseDonType::class, $promesseDon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $promesseDonRepository->save($promesseDon, true);

            return $this->redirectToRoute('app_promesse_don_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promesse_don/edit.html.twig', [
            'promesse_don' => $promesseDon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_promesse_don_delete', methods: ['POST'])]
    public function delete(Request $request, PromesseDon $promesseDon, PromesseDonRepository $promesseDonRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$promesseDon->getId(), $request->request->get('_token'))) {
            $promesseDonRepository->remove($promesseDon, true);
        }

        return $this->redirectToRoute('app_promesse_don_index', [], Response::HTTP_SEE_OTHER);
    }
}
