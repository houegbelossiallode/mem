<?php

namespace App\Controller;

use App\Entity\Boisson;
use App\Entity\Magasin;
use App\Entity\User;
use App\Form\SearchType;
use App\Repository\BoissonRepository;
use App\Repository\MagasinRepository;
use App\Repository\VenteDrinkRepository;
use App\Repository\VenteRepasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;


class DashboardController extends AbstractController
{

    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(
    VenteDrinkRepository $venteDrinkRepository,VenteRepasRepository $venteRepasRepository,
    ChartBuilderInterface $chartBuilder,Request $request): Response
    {
       $venteRepas = $venteRepasRepository->findAll();
       $venteDrinks = $venteDrinkRepository->findAll();
       $label = [];
       $data = [];

       foreach ($venteRepas as $repas) {
          $label [] = $repas->getDate()->format('d/m/Y');
          $data [] = $repas->getMontant();
        
       }
       
       
       
       $labels = [];
       $datas = [];
       $boisson = [];
       
       foreach ($venteDrinks as $vente) 
       {
        $labels [] = $vente->getDate()->format('d/m/Y');
        $datas [] = $vente->getMontant();
        $boisson [] = $vente->getBoisson()->getDesignation();
       }
       

       $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

       $chart->setData([
           'labels' => $labels,
           
           'datasets' => [
               [
                   'label' => 'Vente',
                   'backgroundColor' => 'rgb(255, 99, 132, .4)',
                   'borderColor' => 'rgb(255, 99, 132)',
                   
                   'data' => $datas,
                   'tension' => 0.4,
               ],
               
             //  [
             //   'label' => 'Repas',
             //   'backgroundColor' => 'rgba(252, 191, 73, 0.5)',
             //   'borderColor' => 'rgba(255, 5, 173)',
             //   'pointHoverBackgroundColor'=>'rgba(5, 50, 223, 1)',
                
             //   'data' => $data,
             //   'tension' => 0.4,
           // ],
           ],
       ]);

       $chart->setOptions([
        'plugins' => [
            'zoom' => [
                'zoom' => [
                    'wheel' => ['enabled' => true],
                    'pinch' => ['enabled' => true],
                    'mode' => 'xy',
                ],
            ],
        ]
       ]);
       


       $charts = $chartBuilder->createChart(Chart::TYPE_BAR);

       $charts->setData([
           'labels' => $label,
           
           'datasets' => [
               [
                   'label' => 'Vente',
                   'backgroundColor' => 'rgb(60, 0, 30, .9)',
                   'borderColor' => 'rgb(40, 4, 208)',
                   
                   'data' => $data,
                   'tension' => 0.9,
               ],
               
             //  [
             //   'label' => 'Repas',
             //   'backgroundColor' => 'rgba(252, 191, 73, 0.5)',
             //   'borderColor' => 'rgba(255, 5, 173)',
             //   'pointHoverBackgroundColor'=>'rgba(5, 50, 223, 1)',
                
             //   'data' => $data,
             //   'tension' => 0.4,
           // ],
           ],
       ]);

       $charts->setOptions([
        'plugins' => [
            'zoom' => [
                'zoom' => [
                    'wheel' => ['enabled' => true],
                    'pinch' => ['enabled' => true],
                    'mode' => 'xy',
                ],
            ],
        ]
       ]);

       
       $donnees = [];
       $form = $this->createForm(SearchType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        
        $designation = $form->getData();
      
        $donnees = $venteDrinkRepository->search($designation);
        
        
       }

       
        return $this->render('dashboard/index.html.twig', [
            'chart' => $chart,
            'charts' => $charts,
            'venteDrinks'=> $venteDrinks,
            'form'=> $form->createView(),
            'donnees'=> $donnees,
            
        ]);
    }
}