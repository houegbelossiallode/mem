<?php

namespace App\Controller;

use App\Entity\Proteine;
use App\Form\ProteineType;
use App\Repository\ProteineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/proteine')]
class ProteineController extends AbstractController
{
    #[Route('/', name: 'app_proteine_index', methods: ['GET'])]
    public function index(ProteineRepository $proteineRepository): Response
    {
        return $this->render('proteine/index.html.twig', [
            'proteines' => $proteineRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_proteine_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $proteine = new Proteine();
        $form = $this->createForm(ProteineType::class, $proteine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($proteine);
            $entityManager->flush();

            return $this->redirectToRoute('app_proteine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('proteine/new.html.twig', [
            'proteine' => $proteine,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_proteine_show', methods: ['GET'])]
    public function show(Proteine $proteine): Response
    {
        return $this->render('proteine/show.html.twig', [
            'proteine' => $proteine,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_proteine_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Proteine $proteine, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProteineType::class, $proteine);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_proteine_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('proteine/edit.html.twig', [
            'proteine' => $proteine,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_proteine_delete')]
    public function delete(ManagerRegistry $doctrine,$id): Response
    {
       
        $proteine = new Proteine();
        $proteine = $doctrine->getRepository(Proteine::class)->find($id);
   
        if($proteine)
        {
            $manager = $doctrine->getManager();
            $manager->remove($proteine);
            $manager->flush();
            $this->addFlash("success","Suppression réussi");
        
        }

        return $this->redirectToRoute('app_proteine_index', [], Response::HTTP_SEE_OTHER);
    }
}