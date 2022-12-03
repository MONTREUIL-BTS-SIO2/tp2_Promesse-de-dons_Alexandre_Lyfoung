<?php

namespace App\Controller;

use App\Entity\Campagne;
use App\Entity\PromesseDon;
use App\Form\PromesseDonType;
use App\Repository\CampagneRepository;
use App\Repository\PromesseDonRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use http\Url;

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

    #[Route('/{id}/index', name: 'app_promesse_don_index_id', methods: ['GET', 'POST'])]
    public function indexId(PromesseDonRepository $promesseDonRepository, Request $request, CampagneRepository $campagneRepository)
    {
        $id = $request->attributes->get('id');
        $campagne = $campagneRepository->find($id);
        return $this->render('promesse_don/index.html.twig', [
            'promesse_dons' => $promesseDonRepository->searchByCampagne($id),
            'campagne' => $campagne
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

    #[Route('/new/{id}', name: 'app_promesse_don_new_by_campagne', methods: ['GET', 'POST'])]
    public function newId(Request $request, PromesseDonRepository $promesseDonRepository, CampagneRepository $campagneRepository, int $id): Response
    {
        //dd($request->getPassword());
        $campagnId = $campagneRepository->find($id);
        $promesseDon = new PromesseDon();
        $lastPage = $request->headers->get('referer');
        $form = $this->createForm(PromesseDonType::class, $promesseDon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $promesseDon->setCampagne($campagnId);
            $promesseDonRepository->save($promesseDon, true);

            return $this->redirectToRoute('app_campagne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promesse_don/new.html.twig', [
            'promesse_don' => $promesseDon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_promesse_don_show', methods: ['GET'])]
    public function show(PromesseDon $promesseDon, CampagneRepository $campagneRepository): Response
    {
        return $this->render('promesse_don/show.html.twig', [
            'promesse_don' => $promesseDon,
            'campagne_id' => $campagneRepository->find($promesseDon->getCampagne()->getId())->getId()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_promesse_don_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PromesseDon $promesseDon, PromesseDonRepository $promesseDonRepository, CampagneRepository $campagneRepository): Response
    {
        $form = $this->createForm(PromesseDonType::class, $promesseDon);
        $form->handleRequest($request);
        $campagneId = $campagneRepository->find($promesseDon->getCampagne()->getId())->getId();
        if ($form->isSubmitted() && $form->isValid()) {

            $promesseDonRepository->save($promesseDon, true);

            return $this->redirectToRoute('app_promesse_don_index_id', ['id'=>$campagneId], Response::HTTP_SEE_OTHER);
            //return $this->redirectToRoute('app_promesse_don_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promesse_don/edit.html.twig', [
            'promesse_don' => $promesseDon,
            'form' => $form,
            'campagne_id'=> $campagneId
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
