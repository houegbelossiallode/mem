<?php

namespace App\Controller;

use App\Entity\QuantiteAjoute;
use App\Entity\Vivre;
use App\Form\VivreType;
use App\Repository\VivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use App\Entity\User;

#[Route('/vivre')]
class VivreController extends AbstractController
{
    #[Route('/', name: 'app_vivre_index', methods: ['GET'])]
    public function index(VivreRepository $vivreRepository,MailerInterface $mailer): Response
    {
        $vivre = $vivreRepository->findByVivre();
        $user = $this->getUser();
        
       // Envoi du message d'alerte par mail    
      // $to = $user->getEmail();
      // $subject = 'Listes des vivres à réapprovisionner ';
     //  $email = (new TemplatedEmail())
     //  ->from(new Address('houegbelossiallode@gmail.com', 'Administratrice'))
     //  ->to($to)
     //  ->subject($subject)
     //  ->htmlTemplate('vivre/email.html.twig')
     //  ->context([
     //   'vivre'=> $vivre
     //  ]);

     //  $mailer->send($email);

        
        return $this->render('vivre/index.html.twig', [
            'vivres' => $vivreRepository->findAll(),
            'vivre'=> $vivre
        ]);
    }

    #[Route('/new', name: 'app_vivre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vivre = new Vivre();
        $form = $this->createForm(VivreType::class, $vivre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($vivre);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_vivre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vivre/new.html.twig', [
            'vivre' => $vivre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vivre_show', methods: ['GET'])]
    public function show(Vivre $vivre): Response
    {
        return $this->render('vivre/show.html.twig', [
            'vivre' => $vivre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vivre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vivre $vivre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VivreType::class, $vivre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_vivre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vivre/edit.html.twig', [
            'vivre' => $vivre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_vivre_delete')]
    public function delete(Vivre $vivre,ManagerRegistry $doctrine,int $id): Response
    {
        $vivre = new Vivre();
        $vivre = $doctrine->getRepository(Vivre::class)->find($id);
   
        if($vivre)
        {
            $manager = $doctrine->getManager();
            $manager->remove($vivre);
            $manager->flush();
            $this->addFlash("success","Suppression réussi");
        }

        return $this->redirectToRoute('app_vivre_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/quantite/{id}/add', name: 'add_quantite_vivre')]
    public function ajoutquantite(int $id,ManagerRegistry $doctrine, Request $request,VivreRepository $vivreRepository): Response
    {
       
        $vivre = $vivreRepository->find($id); 
        $manager = $doctrine->getManager();
        $mot = $request->get('ajout');
        $vivre->setQteStock((float)$vivre->getQteStock() + (float)$mot);
        $manager->persist($vivre);
        $manager->flush();
    
        $quantite = new QuantiteAjoute();
        $vivre = $vivreRepository->find($id); 
        $manager = $doctrine->getManager();
        $quantite->setVivre($vivre);
        $quantite->setQuantiteAjoutee($mot);
        $manager->persist($quantite);
        $manager->flush();
        
        return $this->redirectToRoute('app_vivre_index');
    }
    

    #[Route('/quantite/{id}/drop', name: 'drop_quantite_vivre')]
    public function dropquantite(int $id,ManagerRegistry $doctrine, Request $request,VivreRepository $vivreRepository): Response
    {
       
        $vivre = $vivreRepository->find($id); 
        $manager = $doctrine->getManager();
        $mot = $request->get('dimunier');
        if ($mot > $vivre->getQteStock()) {
        //    $this->addFlash("error", "Vous êtes en rupture de pour stock le vivre  " .$vivre->getDesignation() );
            return $this->redirectToRoute('app_vivre_index');
           }
        $vivre->setQteStock($vivre->getQteStock() - (float)$mot);
       // $vivre->setQteSortir((float)$vivre->getQteSortir() + (float)$mot);
        $manager->persist($vivre);
        $manager->flush();
    
        $quantite = new QuantiteAjoute();
        $vivre = $vivreRepository->find($id); 
        $manager = $doctrine->getManager();
        $quantite->setVivre($vivre);
        $quantite->setQuantiteSortir($mot);
        $manager->persist($quantite);
        $manager->flush();
        

        

        return $this->redirectToRoute('app_vivre_index');
    }

    








    
}