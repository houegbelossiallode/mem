<?php

namespace App\Controller;

use App\Entity\Proteine;
use App\Entity\VenteRepas;
use App\Entity\Vivre;
use App\Form\VenteRepasType;
use App\Repository\VenteRepasRepository;
use App\Repository\VivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vente/repas')]
class VenteRepasController extends AbstractController
{
    #[Route('/', name: 'app_vente_repas_index', methods: ['GET'])]
    public function index(VenteRepasRepository $venteRepasRepository): Response
    {
       $vente_repas = $venteRepasRepository->findByProteine();
       // dd($vente_repas);
        return $this->render('vente_repas/index.html.twig', [
            'vente_repas' => $venteRepasRepository->findAll(),
        ]);
    }


    #[Route('/historique', name: 'app_vente_repas_historique')]
    
    public function historique(VenteRepasRepository $venteRepasRepository): Response
    {
        
        return $this->render('vente_repas/historique.html.twig',[
            'vente_repas' => $venteRepasRepository->findAll(),
        ]);
    }

    

    #[Route('/new', name: 'app_vente_repas_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,ManagerRegistry $doctrine, VivreRepository $vivreRepository ): Response
    {
        $id_user = $this->getUser();
        $venteRepa = new VenteRepas();
        $form = $this->createForm(VenteRepasType::class, $venteRepa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
    
            
            $id_proteine = $venteRepa->getProteine()->getId();
            $vivres = $vivreRepository->findBy(['proteine'=>$id_proteine]);
            $qte_vendue = $form->getData()->getQteVendue();
            $prix_vente = $form->getData()->getPrixVente();
            $montant = (int)$qte_vendue * (int)$prix_vente;
            
            if($vivres === null or $vivres === []){
                $vivre = new Vivre();
            }
            else    {
                $vivre = $vivres[0];
            }


            if (!$vivre->getProteine()) {
                $this->addFlash("error", "Ce vivre "  . $venteRepa->getProteine()->getNom().  " n'est pas dans le congelateur " );
                
                return $this->redirectToRoute('app_vente_repas_index');
               }
            
              elseif ( $qte_vendue > $vivre->getQteStock()) {
               $this->addFlash("error", "La quantité de " .$vivre->getProteine(). "  n'est pas suffisante pour honorer la commande" );
                return $this->redirectToRoute('app_vente_repas_index');
               }
               else
               {
                
                $venteRepa->setUser($id_user);
                $venteRepa->setMmontant($montant);
                $entityManager->persist($venteRepa);
                $entityManager->flush();
                $vivre->setQteStock($vivre->getQteStock() -  $qte_vendue);
                $entityManager->persist($vivre);
                $entityManager->flush(); 
                
               }


           
        
            return $this->redirectToRoute('app_vente_repas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vente_repas/new.html.twig', [
            'vente_repa' => $venteRepa,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vente_repas_show', methods: ['GET'])]
    public function show(VenteRepas $venteRepa): Response
    {
        return $this->render('vente_repas/show.html.twig', [
            'vente_repa' => $venteRepa,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vente_repas_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, VenteRepas $venteRepa, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VenteRepasType::class, $venteRepa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $entityManager->persist($venteRepa);
            $entityManager->flush();
            

            return $this->redirectToRoute('app_vente_repas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vente_repas/edit.html.twig', [
            'vente_repa' => $venteRepa,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_vente_repas_delete')]
    public function delete(ManagerRegistry $doctrine,int $id): Response
    {
        $vente_repas = new VenteRepas();
        $vente_repas = $doctrine->getRepository(VenteRepas::class)->find($id);
   
        if($vente_repas)
        {
            $manager = $doctrine->getManager();
            $manager->remove($vente_repas);
            $manager->flush();
            $this->addFlash("success","Suppression réussi");
            return $this->redirectToRoute('app_vente_repas_index', [], Response::HTTP_SEE_OTHER);
        
        }
    }


    #[Route('/{id}/annuler', name: 'app_vente_repas_annuler')]
    public function annuler(VenteRepasRepository $venteRepasRepository, ManagerRegistry $doctrine,int $id,VivreRepository $vivreRepository): Response
    {
        $repas = $venteRepasRepository->find($id); 
        $qte_vendue = $repas->getQteVendue();
        $manager = $doctrine->getManager();
        $repas->setStatut("annuler");
        $manager->persist($repas);
        $manager->flush();


        $id_proteine = $repas->getProteine()->getId();
        $vivres = $vivreRepository->findBy(['proteine'=>$id_proteine]);

        
        if($vivres === null or $vivres === []){
            $vivre = new Vivre();
        }
        else    {
            $vivre = $vivres[0];
        }
        $manager = $doctrine->getManager();
        $vivre->setQteStock($vivre->getQteStock() +  $qte_vendue);
        $manager->persist($vivre);
        $manager->flush();
        
        return $this->redirectToRoute('app_vente_repas_index');
         
    
    }








    






    
}