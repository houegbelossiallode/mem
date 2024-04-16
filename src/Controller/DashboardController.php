<?php

namespace App\Controller;

use App\Entity\Magasin;
use App\Repository\MagasinRepository;
use App\Repository\VenteDrinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(MagasinRepository $magasinRepository,VenteDrinkRepository $venteDrinkRepository,ChartBuilderInterface $chartBuilder): Response
    {
        $magasin = new Magasin();
        $magasin = $magasinRepository->findByBoisson();
       // dd($magasin);
        
       $venteDrinks = $venteDrinkRepository->findAll();
       $labels = [];
       $data = [];
       
       foreach ($venteDrinks as $vente) {
          $labels [] = $vente->getDate()->format('d/m/Y');
          $data [] = $vente->getQuantiteBoissonVendue();
       }
        

       $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

       $chart->setData([
           'labels' => $labels,
           'datasets' => [
               [
                   'label' => 'My First dataset',
                   'backgroundColor' => 'rgb(255, 99, 132)',
                   'borderColor' => 'rgb(255, 99, 132)',
                   'data' => $data,
               ],
           ],
       ]);

       $chart->setOptions([
           
       ]);
       
        return $this->render('dashboard/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}