<?php

namespace App\Controller;

use App\Entity\Boisson;
use App\Form\BoissonType;
use App\Repository\BoissonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/boisson')]
class BoissonController extends AbstractController
{
    #[Route('/', name: 'app_boisson_index', methods: ['GET'])]
    public function index(BoissonRepository $boissonRepository): Response
    {
       
        
        return $this->render('boisson/index.html.twig', [
            'boissons' => $boissonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_boisson_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $boisson = new Boisson();
        $form = $this->createForm(BoissonType::class, $boisson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($boisson);
            $entityManager->flush();

            return $this->redirectToRoute('app_boisson_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('boisson/new.html.twig', [
            'boisson' => $boisson,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_boisson_show', methods: ['GET'])]
    public function show(Boisson $boisson): Response
    {
        return $this->render('boisson/show.html.twig', [
            'boisson' => $boisson,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_boisson_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Boisson $boisson, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BoissonType::class, $boisson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_boisson_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('boisson/edit.html.twig', [
            'boisson' => $boisson,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_boisson_delete')]
    public function delete(Request $request, ManagerRegistry $doctrine,int $id): Response
    {
        
        $boisson = new Boisson();
        $boisson = $doctrine->getRepository(Boisson::class)->find($id);
   
        if($boisson)
        {
            $manager = $doctrine->getManager();
            $manager->remove($boisson);
            $manager->flush();
            $this->addFlash("success","Suppression réussi");
            
        return $this->redirectToRoute('app_boisson_index', [], Response::HTTP_SEE_OTHER);
       }
   }
}