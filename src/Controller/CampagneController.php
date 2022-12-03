<?php

namespace App\Controller;

use App\Entity\Campagne;
use App\Form\CampagneType;
use App\Repository\CampagneRepository;
use PHPUnit\Framework\Constraint\Count;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/campagne')]
class CampagneController extends AbstractController
{
    #[Route('/', name: 'app_campagne_index', methods: ['GET'])]
    public function index(CampagneRepository $campagneRepository): Response
    {
        $mostDonRecolte = $campagneRepository->findMostDonRecolte();
        $mostDon = $campagneRepository->findMostDon();
        $nbTotalDon = $campagneRepository->findNumberDonByCampagne();
        $nbDonHonore = $campagneRepository->findNumberDonHonoreByCamapgne();
        $i = 0;
        $conv_array = array();
        foreach ($nbTotalDon as $don)
        {

            while($i < count($nbDonHonore) && strcmp($don['nom'], $nbDonHonore[$i]['nom']) !== 0)
            {
                $i++;
            }
            if ($i < count($nbDonHonore))
            {
                $conv_array[$don['nom']] = round($nbDonHonore[$i]['Somme']/$don['Somme'], 2);
            }
            else
            {
                $conv_array[$don['nom']] = 0;
            }
        }

        return $this->render('campagne/index.html.twig', [
            'campagnes' => $campagneRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_campagne_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CampagneRepository $campagneRepository): Response
    {
        $campagne = new Campagne();
        $form = $this->createForm(CampagneType::class, $campagne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $campagneRepository->save($campagne, true);

            return $this->redirectToRoute('app_campagne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('campagne/new.html.twig', [
            'campagne' => $campagne,
            'form' => $form,
            'id' => null
        ]);
    }

    #[Route('/{id}', name: 'app_campagne_show', methods: ['GET'])]
    public function show(Campagne $campagne, CampagneRepository $campagneRepository): Response
    {
        $donNonPaye = $campagneRepository->findDonEnAttenteByCampagneID((string)$campagne->getId());
        $donPaye = $campagneRepository->findDonPayeByCampagneID((string)$campagne->getId());
        $nombreTotalDonRecolteCampagne = $campagneRepository->findMostDonRecolteByCampagneId((string)$campagne->getId());
        $nombreTotalDonCampagne = $campagneRepository->findMostDonPromisByCampagneId((string)$campagne->getId());
        $conversion = round($nombreTotalDonRecolteCampagne[0]['Somme']/$nombreTotalDonCampagne[0]['Somme'], 2) *100;
        return $this->render('campagne/show.html.twig', [
            'campagne' => $campagne,
            'conversion'=>$conversion,
            'donsHonores'=>$donPaye,
            'donsNonHonores'=>$donNonPaye
        ]);
    }

    #[Route('/{id}/edit', name: 'app_campagne_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Campagne $campagne, CampagneRepository $campagneRepository): Response
    {
        $form = $this->createForm(CampagneType::class, $campagne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $campagneRepository->save($campagne, true);

            return $this->redirectToRoute('app_campagne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('campagne/edit.html.twig', [
            'campagne' => $campagne,
            'form' => $form,
            'id'=> $campagne->getId(),
        ]);
    }


}
