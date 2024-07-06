<?php

namespace App\Controller;

use App\Entity\Calibre;
use App\Form\CalibreType;
use App\Repository\CalibreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/calibre')]
class CalibreController extends AbstractController
{
    #[Route('/', name: 'app_calibre_index', methods: ['GET'])]
    public function index(CalibreRepository $calibreRepository): Response
    {
        return $this->render('calibre/index.html.twig', [
            'calibres' => $calibreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_calibre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $calibre = new Calibre();
        $form = $this->createForm(CalibreType::class, $calibre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($calibre);
            $entityManager->flush();

            return $this->redirectToRoute('app_calibre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('calibre/new.html.twig', [
            'calibre' => $calibre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_calibre_show', methods: ['GET'])]
    public function show(Calibre $calibre): Response
    {
        return $this->render('calibre/show.html.twig', [
            'calibre' => $calibre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_calibre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Calibre $calibre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CalibreType::class, $calibre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_calibre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('calibre/edit.html.twig', [
            'calibre' => $calibre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_calibre_delete')]
    public function delete( Calibre $calibre, ManagerRegistry $doctrine,int $id): Response
    {
        $calibre = new Calibre();
        $calibre = $doctrine->getRepository(Calibre::class)->find($id);
        if($calibre)
        {
            $manager = $doctrine->getManager();
            $manager->remove($calibre);
            $manager->flush();
            $this->addFlash("success","Suppression réussi");
            
            return $this->redirectToRoute('app_calibre_index', [], Response::HTTP_SEE_OTHER);
       }
    }
}