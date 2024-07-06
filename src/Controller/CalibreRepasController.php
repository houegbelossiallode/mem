<?php

namespace App\Controller;

use App\Entity\CalibreRepas;
use App\Form\CalibreRepasType;
use App\Repository\CalibreRepasRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/calibre_repas')]
class CalibreRepasController extends AbstractController
{
    #[Route('/', name: 'app_calibre_repas_index')]
    public function index(CalibreRepasRepository $calibreRepasRepository): Response
    {
        return $this->render('calibre_repas/index.html.twig', [
            'calibre_repas' => $calibreRepasRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_calibre_repas_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $calibreRepa = new CalibreRepas();
        $form = $this->createForm(CalibreRepasType::class, $calibreRepa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($calibreRepa);
            $entityManager->flush();

            return $this->redirectToRoute('app_calibre_repas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('calibre_repas/new.html.twig', [
            'calibre_repa' => $calibreRepa,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_calibre_repas_show', methods: ['GET'])]
    public function show(CalibreRepas $calibreRepa): Response
    {
        return $this->render('calibre_repas/show.html.twig', [
            'calibre_repa' => $calibreRepa,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_calibre_repas_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CalibreRepas $calibreRepa, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CalibreRepasType::class, $calibreRepa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_calibre_repas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('calibre_repas/edit.html.twig', [
            'calibre_repa' => $calibreRepa,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_calibre_repas_delete')]
    public function delete(CalibreRepas $calibreRepa,$id,ManagerRegistry $doctrine): Response
    {
        $calibreRepa = new CalibreRepas();
        $calibreRepa = $doctrine->getRepository(CalibreRepas::class)->find($id);
   
        if($calibreRepa)
        {
            $manager = $doctrine->getManager();
            $manager->remove($calibreRepa);
            $manager->flush();
            $this->addFlash("success","Suppression réussi");
            
            return $this->redirectToRoute('app_calibre_repas_index', [], Response::HTTP_SEE_OTHER);
       }

        
    }
}