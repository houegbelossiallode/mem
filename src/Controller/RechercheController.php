<?php

namespace App\Controller;

use App\Entity\DepenseVivre;
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




    #[Route('/recherche/solde_date', name: 'recherche_solde_date')]
    public function soldedate(Request $request,VenteDrinkRepository $venteDrinkRepository,DepenseApproRepository $depenseApproRepository ): Response
    {
       $donnees = array('montant'=>0);
       $form = $this->createForm(PeriodeType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        $date = $form->get('date')->getData(); 
        $donnees_depense = $depenseApproRepository->unedate($date);
        $donnees_vente_boisson = $venteDrinkRepository->unedate($date);
        $total_depense = 0;
            foreach($donnees_depense as $depense){
                $total_depense +=$depense['total']; 
            }
            $total_vente = 0;
        
            foreach($donnees_vente_boisson as $vente){
                $total_vente +=$vente['total']; 
            }
        
        $donnees['montant'] = $total_vente -  $total_depense; 

       }
        return $this->render('recherche/solde_date.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }

    

    #[Route('/recherche/solde_mois', name: 'recherche_solde_mois')]
    public function soldemois(Request $request,VenteDrinkRepository $venteDrinkRepository,DepenseApproRepository $depenseApproRepository ): Response
    {
       $donnees = array('montant'=>0);
       $form = $this->createForm(RecherchemoisType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        $date1 = $form->get('date1')->getData(); 
        $date2 = $form->get('date2')->getData(); 
        $donnees_depense = $depenseApproRepository->recherche($date1,$date2);
        $donnees_vente_boisson = $venteDrinkRepository->recherche($date1,$date2);
        $total_depense = 0;
            foreach($donnees_depense as $depense){
                $total_depense +=$depense['total']; 
            }
            $total_vente = 0;
        
            foreach($donnees_vente_boisson as $vente){
                $total_vente +=$vente['total']; 
            }
        
        $donnees['montant'] = $total_vente -  $total_depense; 

       }
        return $this->render('recherche/solde_mois.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }



    #[Route('/recherche/solde_repas_date', name: 'recherche_solde_repas_date')]
    public function solderepasdate(Request $request,DepenseVivreRepository $depenseVivreRepository,VenteRepasRepository $venteRepasRepository ): Response
    {
       $donnees = array('montant'=>0);
       $form = $this->createForm(PeriodeType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        $date = $form->get('date')->getData(); 
        $donnees_depense_vivre = $depenseVivreRepository->unedate($date);
        $donnees_vente_repas =  $venteRepasRepository->unedate($date);
        $total_depense = 0;
            foreach($donnees_depense_vivre as $key=>$depense){
                $total_depense +=$depense['prix']; 
            }
            $total_vente = 0;
        
            foreach($donnees_vente_repas as $key=>$vente){
                $total_vente +=$vente['total']; 
            }
        $donnees['montant'] = $total_vente -  $total_depense; 

       }
        return $this->render('recherche/solde_repas_date.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }


    


    #[Route('/recherche/solde_repas_mois', name: 'recherche_solde_repas_mois')]
    public function solderepasmois(Request $request,VenteRepasRepository $venteRepasRepository,DepenseVivreRepository $depenseVivreRepository): Response
    {
       $donnees = array('montant'=>0);
       $form = $this->createForm(RecherchemoisType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        $date1 = $form->get('date1')->getData(); 
        $date2 = $form->get('date2')->getData(); 
        $donnees_depense_vivre = $depenseVivreRepository->recherche($date1,$date2);
        $donnees_vente_repas = $venteRepasRepository->recherche($date1,$date2);
        $total_depense = 0;
            foreach($donnees_depense_vivre as $depense){
                $total_depense +=$depense['prix']; 
            }
            $total_vente = 0;
        
            foreach($donnees_vente_repas as $vente){
                $total_vente +=$vente['total']; 
            }
        
            $donnees['montant'] = $total_vente -  $total_depense; 

       }
        return $this->render('recherche/solde_repas_mois.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }

   
    
    #[Route('/recherche/recette_date', name: 'recette_date')]
    public function recettedate(Request $request,VenteDrinkRepository $venteDrinkRepository,VenteRepasRepository $venteRepasRepository ): Response
    {
       $donnees = array('montant'=>0);
       $form = $this->createForm(PeriodeType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        $date = $form->get('date')->getData(); 
        $donnees_vente_boisson = $venteDrinkRepository->unedate($date);
        $donnees_vente_repas =  $venteRepasRepository->unedate($date);
        $total_vente_boisson = 0;
            foreach($donnees_vente_boisson as $vente_boisson){
                $total_vente_boisson +=$vente_boisson['total']; 
            }
            $total_vente_repas = 0;
        
            foreach($donnees_vente_repas as $vente_repas){
                $total_vente_repas +=$vente_repas['total']; 
            }
        $donnees['montant'] = $total_vente_boisson +  $total_vente_repas; 

       }
        return $this->render('recherche/date_recette.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }


    #[Route('/recherche/recette_mois', name: 'recette_mois')]
    public function recettemois(Request $request,VenteDrinkRepository $venteDrinkRepository,VenteRepasRepository $venteRepasRepository ): Response
    {
       $donnees = array('montant'=>0);
       $form = $this->createForm(RecherchemoisType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        $date1 = $form->get('date1')->getData(); 
        $date2 = $form->get('date2')->getData();
        $donnees_vente_boisson = $venteDrinkRepository->recherche($date1,$date2);
        $donnees_vente_repas =  $venteRepasRepository->recherche($date1,$date2);
        $total_vente_boisson = 0;
            foreach($donnees_vente_boisson as $vente_boisson){
                $total_vente_boisson +=$vente_boisson['total']; 
            }
            $total_vente_repas = 0;
        
            foreach($donnees_vente_repas as $vente_repas){
                $total_vente_repas +=$vente_repas['total']; 
            }
        $donnees['montant'] = $total_vente_boisson +  $total_vente_repas; 

       }
        return $this->render('recherche/mois_recette.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }



    #[Route('/recherche/recette_electronique_date', name: 'recette_electronique_date')]
    public function recette_electronique_date(Request $request,VenteDrinkRepository $venteDrinkRepository,VenteRepasRepository $venteRepasRepository ): Response
    {
       $donnees = array('montant'=>0);
       $form = $this->createForm(PeriodeType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        $date = $form->get('date')->getData(); 
        $donnees_vente_boisson = $venteDrinkRepository->unedateelectronique($date);
        $donnees_vente_repas =  $venteRepasRepository->unedateelectronique($date);
        $total_vente_boisson = 0;
            foreach($donnees_vente_boisson as $vente_boisson){
                $total_vente_boisson +=$vente_boisson['total']; 
            }
            $total_vente_repas = 0;
        
            foreach($donnees_vente_repas as $vente_repas){
                $total_vente_repas +=$vente_repas['total']; 
            }
        $donnees['montant'] = $total_vente_boisson +  $total_vente_repas; 

       }
        return $this->render('recherche/date_recette_electronique.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }



    #[Route('/recherche/recette_electronique_mois', name: 'recette_electronique_mois')]
    public function recette_electronique_mois(Request $request,VenteDrinkRepository $venteDrinkRepository,VenteRepasRepository $venteRepasRepository ): Response
    {
       $donnees = array('montant'=>0);
       $form = $this->createForm(RecherchemoisType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        $date1 = $form->get('date1')->getData(); 
        $date2 = $form->get('date2')->getData();
        $donnees_vente_boisson = $venteDrinkRepository->rechercheelectronique($date1,$date2);
        $donnees_vente_repas =   $venteRepasRepository->rechercheelectronique($date1,$date2);
        $total_vente_boisson = 0;
            foreach($donnees_vente_boisson as $vente_boisson){
                $total_vente_boisson +=$vente_boisson['total']; 
            }
            $total_vente_repas = 0;
        
            foreach($donnees_vente_repas as $vente_repas){
                $total_vente_repas +=$vente_repas['total']; 
            }
        $donnees['montant'] = $total_vente_boisson +  $total_vente_repas; 

       }
        return $this->render('recherche/mois_recette_electronique.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }



    #[Route('/recherche/recette_numeraire_date', name: 'recette_numeraire_date')]
    public function recette_numeraire_date(Request $request,VenteDrinkRepository $venteDrinkRepository,VenteRepasRepository $venteRepasRepository ): Response
    {
       $donnees = array('montant'=>0);
       $form = $this->createForm(PeriodeType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        $date = $form->get('date')->getData(); 
        $donnees_vente_boisson = $venteDrinkRepository->unedatenumeraire($date);
        $donnees_vente_repas =   $venteRepasRepository->unedatenumeraire($date);
        $total_vente_boisson = 0;
            foreach($donnees_vente_boisson as $vente_boisson){
                $total_vente_boisson +=$vente_boisson['total']; 
            }
            $total_vente_repas = 0;
        
            foreach($donnees_vente_repas as $vente_repas){
                $total_vente_repas +=$vente_repas['total']; 
            }
        $donnees['montant'] = $total_vente_boisson +  $total_vente_repas; 

       }
        return $this->render('recherche/date_recette_numeraire.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }

    

 
    
    #[Route('/recherche/recette_numeraire_mois', name: 'recette_numeraire_mois')]
    public function recette_numeraire_mois(Request $request,VenteDrinkRepository $venteDrinkRepository,VenteRepasRepository $venteRepasRepository ): Response
    {
       $donnees = array('montant'=>0);
       $form = $this->createForm(RecherchemoisType::class);
       $form->handleRequest($request);
       
       if($form->isSubmitted() && $form->isValid())
       {
        $date1 = $form->get('date1')->getData(); 
        $date2 = $form->get('date2')->getData();
        $donnees_vente_boisson = $venteDrinkRepository->recherchenumeraire($date1,$date2);
        $donnees_vente_repas =   $venteRepasRepository->recherchenumeraire($date1,$date2);
        $total_vente_boisson = 0;
            foreach($donnees_vente_boisson as $vente_boisson){
                $total_vente_boisson +=$vente_boisson['total']; 
            }
            $total_vente_repas = 0;
        
            foreach($donnees_vente_repas as $vente_repas){
                $total_vente_repas +=$vente_repas['total']; 
            }
        $donnees['montant'] = $total_vente_boisson +  $total_vente_repas; 

       }
        return $this->render('recherche/mois_recette_numeraire.html.twig', [
         'form'=> $form->createView(),
         'donnees'=> $donnees,
        ]);
    }

    

    
}