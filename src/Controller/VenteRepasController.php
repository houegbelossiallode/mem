<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Entity\VenteRepas;
use App\Form\VenteRepasType;
use App\Repository\VenteRepasRepository;
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
        return $this->render('vente_repas/index.html.twig', [
            'vente_repas' => $venteRepasRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_vente_repas_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,ManagerRegistry $doctrine): Response
    {
        $venteRepa = new VenteRepas();
        $form = $this->createForm(VenteRepasType::class, $venteRepa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $entityManager->persist($venteRepa);
            $entityManager->flush();
            $id = $venteRepa->getId();
            
            
           

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
    public function delete(Request $request, ManagerRegistry $doctrine,int $id): Response
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
    public function annuler(VenteRepasRepository $venteRepasRepository, ManagerRegistry $doctrine,int $id): Response
    {
        $repas = $venteRepasRepository->find($id); 
        $manager = $doctrine->getManager();
        $repas->setStatut("annuler");
        $manager->persist($repas);
        $manager->flush();

        return $this->redirectToRoute('app_vente_repas_index');
         
    
    }








    






    
}