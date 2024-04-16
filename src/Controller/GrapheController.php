<?php

namespace App\Controller;

use App\Repository\VenteDrinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class GrapheController extends AbstractController
{
    #[Route('/graphe', name: 'app_graphe')]
    public function index(VenteDrinkRepository $venteDrinkRepository,ChartBuilderInterface $chartBuilder): Response
    {

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
        return $this->render('graphe/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}