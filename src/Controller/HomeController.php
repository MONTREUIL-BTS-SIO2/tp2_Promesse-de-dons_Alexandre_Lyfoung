<?php

namespace App\Controller;

use App\Repository\CampagneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {

        $user = $this->getUser();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/stats', name:'app_stats')]
    public function stats(CampagneRepository $campagneRepository)
    {
        $mostDonRecolte = $campagneRepository->findMostDonRecolte();
        $mostDon = $campagneRepository->findMostDon();
        $nbTotalDon = $campagneRepository->findNumberDonByCampagne();
        $nbDonHonore = $campagneRepository->findNumberDonHonoreByCamapgne();

        $i = 0;
        $j=0;
        $conv_array = [];
        $conversion = array();
        foreach ($nbTotalDon as $don)
        {
            while($i < count($nbDonHonore) && strcmp($don['nom'], $nbDonHonore[$i]['nom']) !== 0)
            {
                $i++;
            }

            if ($i < count($nbDonHonore))
            {
                $nbTotalDon[$i]['Somme'] = round($nbDonHonore[$i]['Somme']/$don['Somme'], 2) * 100;
            }
            else
            {
                $nbTotalDon[$j]['Somme'] = 0;
            }
            $i = 0;
            $j++;
        }
        $j=0;
        $max = 0;
        $nom = "";
        $index = 0;
        for ($a = 0; $a < 3; $a++)
        {
            foreach ($nbTotalDon as $don)
            {
                if($don['Somme'] > $max)
                {
                    $nom = $don['nom'];
                    $max = $don['Somme'];
                    $index = $j;
                }
                $j++;

            }
            $conv_array[] = $nom;
            $conv_array[] = $max;
            unset($nbTotalDon[$index]);

            $max = 0;
            $nom = "";
            $j = 0;
        }
        $conversion = array($conv_array[0] => $conv_array[1], $conv_array[2] => $conv_array[3], $conv_array[4] => $conv_array[5]);
        return $this->render('home/stats.html.twig',[
            'Dons3Recu'=>$mostDonRecolte,
            'plusDon3' => $mostDon,
            'conversion' =>$conversion
        ]);
    }


}
