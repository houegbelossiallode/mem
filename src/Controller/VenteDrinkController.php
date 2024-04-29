<?php

namespace App\Controller;

use App\Entity\Congelateur;
use App\Entity\Recette;
use App\Entity\VenteDrink;
use App\Form\VenteDrinkType;
use App\Repository\CongelateurRepository;
use App\Repository\VenteDrinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vente/drink')]
class VenteDrinkController extends AbstractController
{
    #[Route('/', name: 'app_vente_drink_index', methods: ['GET'])]
    public function index(VenteDrinkRepository $venteDrinkRepository): Response
    {
        
        return $this->render('vente_drink/index.html.twig', [
            'vente_drinks' => $venteDrinkRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vente_drink_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,VenteDrinkRepository $venteDrinkRepository, CongelateurRepository $congelateurRepository
    ,ManagerRegistry $doctrine): Response
    {
        $id = $this->getUser();
        $venteDrink = new VenteDrink();
        $form = $this->createForm(VenteDrinkType::class, $venteDrink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            
            $quantite_vendue = $form->getData()->getQuantiteBoissonVendue();
            $prix_vente = $form->getData()->getPrixVente();
            $montant = (int)$quantite_vendue * (int)$prix_vente;
           
            

            $boisson = $venteDrink->getBoisson()->getId();
        
            $congelateurs = $congelateurRepository->findBy(['boisson'=>$boisson]);
            
            if($congelateurs === null or $congelateurs === []){
                $congelateur = new Congelateur();
            }
            else    {
                $congelateur = $congelateurs[0];
            }
           
            $manager = $doctrine->getManager();
            
            if (!$congelateur->getBoisson()) {
                $this->addFlash("success", " Cette boisson"  .$congelateur->getBoisson().  " n'est pas dans le congelateur " );
                
                return $this->redirectToRoute('app_vente_drink_index');
               }
               elseif ($quantite_vendue > $congelateur->getQteStock()) {
                $this->addFlash("error", "La quantité de " .$congelateur->getBoisson().  " n'est pas suffisante pour honorer la commande" );
                return $this->redirectToRoute('app_vente_drink_index');
               }
               else{
                
                $venteDrink->setMontant($montant);
                $venteDrink->setUser($id);
                $entityManager->persist($venteDrink);
                $entityManager->flush();
                $congelateur->setQteStock($congelateur->getQteStock() -  $quantite_vendue);
                $manager->persist($congelateur);
                $manager->flush(); 
               }
            
                     

            return $this->redirectToRoute('app_vente_drink_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vente_drink/new.html.twig', [
            'vente_drink' => $venteDrink,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vente_drink_show', methods: ['GET'])]
    public function show(VenteDrink $venteDrink): Response
    {
        return $this->render('vente_drink/show.html.twig', [
            'vente_drink' => $venteDrink,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vente_drink_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, VenteDrink $venteDrink, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VenteDrinkType::class, $venteDrink);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vente_drink_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vente_drink/edit.html.twig', [
            'vente_drink' => $venteDrink,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vente_drink_delete', methods: ['POST'])]
    public function delete(Request $request, VenteDrink $venteDrink, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$venteDrink->getId(), $request->request->get('_token'))) {
            $entityManager->remove($venteDrink);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_vente_drink_index', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('/{id}/annuler', name: 'app_vente_drink_annuler', methods: ['GET', 'POST'])]
    public function annuler(CongelateurRepository $congelateurRepository,VenteDrinkRepository $venteDrinkRepository,int $id,ManagerRegistry $doctrine): Response
    {
       
        $vente = $venteDrinkRepository->find($id); 
        $quantite_vendue = $vente->getQuantiteBoissonVendue();
        $manager = $doctrine->getManager();
        $vente->setStatut("annuler");
        $manager->persist($vente);
        $manager->flush();

       
        
        $boisson = $vente->getBoisson()->getId();
        $congelateurs = $congelateurRepository->findBy(['boisson'=>$boisson]);
            
            if($congelateurs === null or $congelateurs === []){
                $congelateur = new Congelateur();
            }
            else    {
                $congelateur = $congelateurs[0];
            }
        $manager = $doctrine->getManager();
        $congelateur->setQteStock($congelateur->getQteStock() +  $quantite_vendue);
       // $manager->remove($quantite_vendue);
        $manager->persist($congelateur);
        $manager->flush();
        
        
        return $this->redirectToRoute('app_vente_drink_index');
    }

    
}