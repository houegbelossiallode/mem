<?php

namespace App\Controller;

use App\Entity\Congelateur;
use App\Entity\Magasin;
use App\Entity\QuantiteAjoute;
use App\Entity\User;
use App\Form\MagasinType;
use App\Repository\BoissonRepository;
use App\Repository\CongelateurRepository;
use App\Repository\MagasinRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

#[Route('/magasin')]
class MagasinController extends AbstractController
{
    #[Route('/', name: 'app_magasin_index', methods: ['GET'])] 
    public function index(MagasinRepository $magasinRepository,MailerInterface $mailer,BoissonRepository $boissonRepository): Response
    {
        $user = new User();
        $magasin = $magasinRepository->findByBoisson();
        $user = $this->getUser();
       // dd($boisson);
       // Envoi du message d'alerte par mail    
       $to = $user->getEmail();
       $subject = 'Listes des boissons à réapprovisionner ';
       $email = (new TemplatedEmail())
       ->from(new Address('houegbelossiallode@gmail.com', 'Administratrice'))
       ->to($to)
       ->subject($subject)
       ->htmlTemplate('magasin/email.html.twig')
       ->context([
        'magasin'=> $magasin
       ]);

       $mailer->send($email);

       
        return $this->render('magasin/index.html.twig', [
            'magasins' => $magasinRepository->findAll(),
            'magasin'=>$magasin
        ]);
    }

    #[Route('/new', name: 'app_magasin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $magasin = new Magasin();
        $form = $this->createForm(MagasinType::class, $magasin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($magasin);
            $entityManager->flush();

            return $this->redirectToRoute('app_magasin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('magasin/new.html.twig', [
            'magasin' => $magasin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_magasin_show', methods: ['GET'])]
    public function show(Magasin $magasin): Response
    {
        return $this->render('magasin/show.html.twig', [
            'magasin' => $magasin,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_magasin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Magasin $magasin, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MagasinType::class, $magasin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_magasin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('magasin/edit.html.twig', [
            'magasin' => $magasin,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_magasin_delete', methods: ['POST'])]
    public function delete(Request $request, Magasin $magasin, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$magasin->getId(), $request->request->get('_token'))) {
            $entityManager->remove($magasin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_magasin_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/quantite/{id}/add', name: 'add_quantite')]
    public function ajoutquantite(int $id,ManagerRegistry $doctrine, Request $request,MagasinRepository $magasinRepository): Response
    {
       
        $magasin = $magasinRepository->find($id); 
        $manager = $doctrine->getManager();
        $mot = $request->get('ajout');
        $magasin->setQuantiteStock((float)$magasin->getQuantiteStock() + (float)$mot);
      //  $manager->persist($magasin);
        $manager->flush();
    
        $quantite = new QuantiteAjoute();
        $magasin = $magasinRepository->find($id); 
        $manager = $doctrine->getManager();
        $quantite->setMagasin($magasin);
        $quantite->setQuantiteAjoutee($mot);
        $manager->persist($quantite);
        $manager->flush();
        
        return $this->redirectToRoute('app_magasin_index');
    }
    


    #[Route('/quantite/{id}/drop', name: 'drop_quantite')]
    public function dropquantite(int $id,ManagerRegistry $doctrine, Request $request,MagasinRepository $magasinRepository,CongelateurRepository $congelateurRepository): Response
    {
       
        $magasin = $magasinRepository->find($id); 
        $manager = $doctrine->getManager();
        $mot = $request->get('dimunier');
        if ($mot > $magasin->getQuantiteStock()) {
            $this->addFlash("error", "Vous êtes en rupture de stock veuillez réapprovisionner " .$magasin->getBoisson());
            return $this->redirectToRoute('app_magasin_index');
           }
        $magasin->setQuantiteStock((float)$magasin->getQuantiteStock() - (float)$mot);
        $magasin->setQuantiteSortirResto((float)$magasin->getQuantiteSortirResto() + (float)$mot);
        $manager->persist($magasin);
        $manager->flush();
        
        $quantite = new QuantiteAjoute();
        $magasin = $magasinRepository->find($id); 
        $manager = $doctrine->getManager();
        $quantite->setMagasin($magasin);
        $quantite->setQuantiteSortir($mot);
        $manager->persist($quantite);
        $manager->flush();
        

        
        $boisson = $magasin->getBoisson()->getId();
        
        $congelateurs = $congelateurRepository->findBy(['boisson'=>$boisson]);
        
        if($congelateurs === null or $congelateurs === [])
        {
            $congelateur = new Congelateur();
        }
        else    {
            $congelateur = $congelateurs[0];
        }
       
        $manager = $doctrine->getManager();
        $mot = $request->get('dimunier');
        $boisson = $magasin->getBoisson()->getId();
       //  if ($boisson == '19') {
        //  dd($congelateur->getQteStock());
            
       // }
       // dd($boisson = $congelateur->getQteStock());
       // $congelateur->setBoisson($magasin->getBoisson());
        
       // if ($boisson == '19') {
       //   dd($congelateur->getQteStock());
            
       // }
       // else{
       //     $congelateur->setQteStock($mot); 
       // }
       $congelateur->setBoisson($magasin->getBoisson());
       $congelateur->setQteStock($congelateur->getQteStock() + $mot);
        $manager->persist($congelateur);
        $manager->flush();
        

        return $this->redirectToRoute('app_magasin_index');
    }









    
}