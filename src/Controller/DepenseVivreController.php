<?php

namespace App\Controller;

use App\Entity\DepenseVivre;
use App\Form\DepenseVivreType;
use App\Repository\DepenseVivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/depense/vivre')]
class DepenseVivreController extends AbstractController
{
    #[Route('/', name: 'app_depense_vivre_index', methods: ['GET'])]
    public function index(DepenseVivreRepository $depenseVivreRepository): Response
    {
        return $this->render('depense_vivre/index.html.twig', [
            'depense_vivres' => $depenseVivreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_depense_vivre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $depenseVivre = new DepenseVivre();
        $form = $this->createForm(DepenseVivreType::class, $depenseVivre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($depenseVivre);
            $entityManager->flush();

            return $this->redirectToRoute('app_depense_vivre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('depense_vivre/new.html.twig', [
            'depense_vivre' => $depenseVivre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_depense_vivre_show', methods: ['GET'])]
    public function show(DepenseVivre $depenseVivre): Response
    {
        return $this->render('depense_vivre/show.html.twig', [
            'depense_vivre' => $depenseVivre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_depense_vivre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DepenseVivre $depenseVivre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DepenseVivreType::class, $depenseVivre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_depense_vivre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('depense_vivre/edit.html.twig', [
            'depense_vivre' => $depenseVivre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_depense_vivre_delete', methods: ['POST'])]
    public function delete(Request $request, DepenseVivre $depenseVivre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$depenseVivre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($depenseVivre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_depense_vivre_index', [], Response::HTTP_SEE_OTHER);
    }
}