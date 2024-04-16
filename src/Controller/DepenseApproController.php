<?php

namespace App\Controller;

use App\Entity\DepenseAppro;
use App\Form\DepenseApproType;
use App\Repository\DepenseApproRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/depense/appro')]
class DepenseApproController extends AbstractController
{
    #[Route('/', name: 'app_depense_appro_index', methods: ['GET'])]
    public function index(DepenseApproRepository $depenseApproRepository): Response
    {
        $depense = $depenseApproRepository->getNb();
        
        return $this->render('depense_appro/index.html.twig', [
            'depense_appros' => $depenseApproRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_depense_appro_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $depenseAppro = new DepenseAppro();
        $form = $this->createForm(DepenseApproType::class, $depenseAppro);
        $form->handleRequest($request);
        $total = 0;
        if ($form->isSubmitted() && $form->isValid()) {
            $quantite = $form->getData()->getQuantiteAchete();
            $prix = $form->getData()->getPrixUnitaire();
            $nombre_trou = $form->getData()->getNombreTrou();
            $montant = (int)$quantite * (int)$prix;
            $trou = (int)$quantite * (int)$nombre_trou;
            $depenseAppro->setMontant($montant);
            $depenseAppro->setNombreTrou($trou);
            $entityManager->persist($depenseAppro);
            $entityManager->flush();

            return $this->redirectToRoute('app_depense_appro_index', [], Response::HTTP_SEE_OTHER);
        }
         
        return $this->renderForm('depense_appro/new.html.twig', [
            'depense_appro' => $depenseAppro,
            'form' => $form,
            'total' => $total,
        ]);
    }

    #[Route('/{id}', name: 'app_depense_appro_show', methods: ['GET'])]
    public function show(DepenseAppro $depenseAppro): Response
    {
        return $this->render('depense_appro/show.html.twig', [
            'depense_appro' => $depenseAppro,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_depense_appro_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DepenseAppro $depenseAppro, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DepenseApproType::class, $depenseAppro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quantite = $form->getData()->getQuantiteAchete();
            $prix = $form->getData()->getPrixUnitaire();
            $montant = $quantite * $prix;
           
            $depenseAppro->setMontant($montant);
            $entityManager->persist($depenseAppro);
            $entityManager->flush();

            return $this->redirectToRoute('app_depense_appro_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('depense_appro/edit.html.twig', [
            'depense_appro' => $depenseAppro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_depense_appro_delete')]
    public function delete(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $depense = new DepenseAppro();
        $depense = $doctrine->getRepository(DepenseAppro::class)->find($id);
   
        if($depense)
        {
            $manager = $doctrine->getManager();
            $manager->remove($depense);
            $manager->flush();
            $this->addFlash("success","Suppression réussi");

            return $this->redirectToRoute('app_depense_appro_index', [], Response::HTTP_SEE_OTHER);
        }

    }
}