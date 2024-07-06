<?php

namespace App\Controller;

use App\Entity\Congelateur;
use App\Form\CongelateurType;
use App\Entity\User;
use App\Repository\CongelateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

#[Route('/congelateur')]
class CongelateurController extends AbstractController
{
    #[Route('/', name: 'app_congelateur_index', methods: ['GET'])]
    public function index(CongelateurRepository $congelateurRepository,MailerInterface $mailer): Response
    {
        $user = new User();
        $user = $this->getUser();
        $conge = $congelateurRepository->findByBoisson();
      
        
      // foreach ($conge as $conges)
      //  {  
      //  $mavariable = $conges["designation"];
      //  }  
      
     // if($conge){

     //   $to = $user->getEmail();
     //   $subject = 'Listes des boissons à réapprovisionner ';
     //   $email = (new TemplatedEmail())
    //   ->from(new Address('houegbelossiallode@gmail.com', 'LES DÉLICES DU COIN'))
    //   ->to($to)
    //   ->subject($subject)
    //   ->htmlTemplate('congelateur/email.html.twig')
    //   ->context([
    //    'conge'=> $conge
    //    ]);
        
    //    $mailer->send($email);

    //  }
        
         
       
        $congelateurs = $congelateurRepository->findAll();
        return $this->render('congelateur/index.html.twig', [
            'congelateurs' => $congelateurs,
            'conge'=>$conge 
        ]);
    }

    #[Route('/new', name: 'app_congelateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $congelateur = new Congelateur();
        $form = $this->createForm(CongelateurType::class, $congelateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($congelateur);
            $entityManager->flush();

            return $this->redirectToRoute('app_congelateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('congelateur/new.html.twig', [
            'congelateur' => $congelateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_congelateur_show', methods: ['GET'])]
    public function show(Congelateur $congelateur): Response
    {
        return $this->render('congelateur/show.html.twig', [
            'congelateur' => $congelateur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_congelateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Congelateur $congelateur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CongelateurType::class, $congelateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_congelateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('congelateur/edit.html.twig', [
            'congelateur' => $congelateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_congelateur_delete', methods: ['POST'])]
    public function delete(Request $request, Congelateur $congelateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$congelateur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($congelateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_congelateur_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/congelateur/{id}/drop', name: 'drop_quantite')]
    public function dropquantite(int $id,CongelateurRepository $congelateurRepository): Response
    {
       
        $congelateur = $congelateurRepository->find($id); 
        
        
        dd($congelateur->getQteStock());
        
       



    }



    
}