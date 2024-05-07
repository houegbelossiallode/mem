<?php

namespace App\Controller;

use App\Form\PeriodeType;
use App\Form\RecherchemoisType;
use App\Repository\DepenseApproRepository;
use App\Repository\DepenseVivreRepository;
use App\Repository\RecetteRepository;
use App\Repository\VenteDrinkRepository;
use App\Repository\VenteRepasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RechercheController extends AbstractController
{
    #[Route('/recherche', name: 'app_recherche')]
    public function index(Request $request,VenteDrinkRepository $venteDrinkRepository): Response
    {
       $donnees = [];
       $form = $this->createForm(PeriodeType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        
       $date = $form->get('date')->getData(); 
       
        $donnees = $venteDrinkRepository->unedate($date);
        
        
       }
        return $this->render('recherche/date.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }



    #[Route('/recherche/mois', name: 'recherche_mois')]
    public function mois(Request $request,VenteDrinkRepository $venteDrinkRepository): Response
    {
       $donnees = [];
       $form = $this->createForm(RecherchemoisType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
       $date1 = $form->get('date1')->getData(); 
       $date2 = $form->get('date2')->getData(); 
       $donnees = $venteDrinkRepository->recherche($date1,$date2);
       // dd($donnees['designation']);
       }
        return $this->render('recherche/mois.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }




    #[Route('/recherche/date_repas', name: 'recherche_date_repas')]
    public function dateventerepas(Request $request,VenteRepasRepository $venteRepasRepository): Response
    {
       $donnees = [];
       $form = $this->createForm(PeriodeType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        
        $date = $form->get('date')->getData(); 
       
        $donnees = $venteRepasRepository->unedate($date);
        
        
       }
        return $this->render('recherche/date_repas.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }



    #[Route('/recherche/repas', name: 'recherche_mois_repas')]
    public function moisventerepas(Request $request,VenteRepasRepository $venteRepasRepository): Response
    {
       $donnees = [];
       $form = $this->createForm(RecherchemoisType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        
        $date1 = $form->get('date1')->getData(); 
        $date2 = $form->get('date2')->getData(); 
        $donnees = $venteRepasRepository->recherche($date1,$date2);
        
        
       }
        return $this->render('recherche/mois_repas.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }



    #[Route('/depense_boisson/date', name: 'depense_date_boisson')]
    public function datedepenseboisson(Request $request,DepenseApproRepository $depenseApproRepository): Response
    {
       $donnees = [];
       $form = $this->createForm(PeriodeType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        
        $date = $form->get('date')->getData(); 
       
        $donnees = $depenseApproRepository->unedate($date);
        
        
       }
        return $this->render('recherche/date_depense_boisson.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }



    #[Route('/depense_boisson/mois', name: 'depense_mois_boisson')]
    public function moisdepenseboisson(Request $request,DepenseApproRepository $depenseApproRepository): Response
    {
       $donnees = [];
       $form = $this->createForm(RecherchemoisType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        
        $date1 = $form->get('date1')->getData(); 
        $date2 = $form->get('date2')->getData(); 
        $donnees = $depenseApproRepository->recherche($date1,$date2);
        
        
       }
        return $this->render('recherche/mois_depense_boisson.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }




    #[Route('/depense_vivre/date', name: 'depense_date_vivre')]
    public function datedepensevivre(Request $request,DepenseVivreRepository $depenseVivreRepository): Response
    {
       $donnees = [];
       $form = $this->createForm(PeriodeType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        
        $date = $form->get('date')->getData(); 
       
        $donnees = $depenseVivreRepository->unedate($date);
        
        
       }
        return $this->render('recherche/date_depense_vivre.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }



    #[Route('/depense_vivre/mois', name: 'depense_mois_vivre')]
    public function moisdepensevivre(Request $request,DepenseVivreRepository $depenseVivreRepository): Response
    {
       $donnees = [];
       $form = $this->createForm(RecherchemoisType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        
        $date1 = $form->get('date1')->getData(); 
        $date2 = $form->get('date2')->getData(); 
        $donnees = $depenseVivreRepository->recherche($date1,$date2);
        
        
       }
        return $this->render('recherche/mois_depense_vivre.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }
    

    #[Route('/recette/date', name: 'recette_date')]
    public function daterecette(Request $request,RecetteRepository $recetteRepository): Response
    {
       $donnees = [];
       $form = $this->createForm(PeriodeType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        
        $date = $form->get('date')->getData(); 
       
        $donnees = $recetteRepository->getDateRecette($date);
       // dd($donnees);
        
       }
        return $this->render('recherche/date_recette.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }



    #[Route('/recherche/date_lait', name: 'recherche_date_lait')]
    public function datelait(Request $request,VenteDrinkRepository $venteDrinkRepository): Response
    {
       $donnees = [];
       $form = $this->createForm(PeriodeType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        
        $date = $form->get('date')->getData(); 
       
        $donnees = $venteDrinkRepository->findBylaitunedate($date);
        
        
       }
        return $this->render('recherche/date_lait.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }



    #[Route('/recherche/mois_lait', name: 'recherche_mois_lait')]
    public function moislait(Request $request,VenteDrinkRepository $venteDrinkRepository): Response
    {
       $donnees = [];
       $form = $this->createForm(RecherchemoisType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        
        $date1 = $form->get('date1')->getData(); 
        $date2 = $form->get('date2')->getData(); 
        $donnees = $venteDrinkRepository->findBylaitdeuxdate($date1,$date2);
        
        
       }
        return $this->render('recherche/mois_lait.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }



    


    
}