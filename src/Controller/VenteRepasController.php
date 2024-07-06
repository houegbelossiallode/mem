<?php

namespace App\Controller;

use App\Entity\Proteine;
use App\Entity\VenteRepas;
use App\Entity\Calibre;
use App\Entity\Repas;
use App\Entity\Vivre;
use App\Form\VenteRepasType;
use App\Repository\CalibreRepasRepository;
use App\Repository\CalibreRepository;
use App\Repository\ProteineRepository;
use App\Repository\VenteRepasRepository;
use App\Repository\VivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RepasRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Constraints\Length;

#[Route('/vente/repas')]
class VenteRepasController extends AbstractController
{
    #[Route('/', name: 'app_vente_repas_index', methods: ['GET'])]
    public function index(VenteRepasRepository $venteRepasRepository, EntityManagerInterface $entityManager): Response
    {
        // $repository = $entityManager->getRepository(Proteine::class);
        //$entity = $repository->findAll();
       // dd($entity);
       $vente_repas = $venteRepasRepository->findByProteine();
       // dd($vente_repas);
        return $this->render('vente_repas/index.html.twig', [
            'vente_repas' => $venteRepasRepository->findAll(),
        ]);
    }


    #[Route('/historique', name: 'app_vente_repas_historique')]
    
    public function historique(VenteRepasRepository $venteRepasRepository): Response
    {
        
        return $this->render('vente_repas/historique.html.twig',[
            'vente_repas' => $venteRepasRepository->findAll(),
        ]);
    }

    


    #[Route('/cart', name: 'app_cart')]
    public function cart(RepasRepository $repasRepository,ProteineRepository $proteineRepository,SessionInterface $session): Response
    {
       
        
        $panier = $session->get('panier', []);
       // $panier2 = $session->get('panier2', []);
        // On initialise des variables
        $data = [];
        $two = [];
        $total = 0;
        
        foreach($panier as $repas => $qte_vendue)
        {
           
            $repas = $repasRepository->find($repas);
           // dd($repas);
            
            $data[] = [
                
                'repas' => $repas,
                'qte_vendue' => $qte_vendue
            ];

        }

       // foreach($panier2 as $id_proteine => $qte_vendue)
       // {
           
            
        //    $proteine = $proteineRepository->find($id_proteine);
          //  dd($proteine);
        //   $two[] = [
        //        'proteine' => $proteine,
        //        'qte_vendue' => $qte_vendue
        //    ];

       // }
      //  exit;




        
       // $count = COUNT($data);
        
        return $this->render('vente_repas/cart_index.html.twig', [
            'data' => $data,
            'two' => $two,
             'total' => $total,
             
             
        ]);
    }





    
     #[Route('/new', name: 'app_vente_repas_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,VivreRepository $vivreRepository ): Response
    {
        $id_user = $this->getUser();
        $calibre = new Calibre();
        $id_proteine = new Repas();
      // dd ($id_proteine->getAccompagnement());
        $venteRepa = new VenteRepas();
        $form = $this->createForm(VenteRepasType::class, $venteRepa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
    
           
            $id_proteine = $venteRepa->getProteine() ? $venteRepa->getProteine()->getId() : null;
            $vivres = $vivreRepository->findBy(['proteine'=>$id_proteine]);
            $qte_vendue_proteine = $form->getData()->getQteVendue();
            $qte_vendue_accompagnement = $form->getData()->getQte();
            $prix_vente_proteine =  $form->getData()->getPrixVenteProteine();
           // dd($id_proteine);
            $prix_vente_accompagnement =  $form->getData()->getPrixVenteAccompagnement();
           // $prix_vente = $form->getData()->getPrixVente();
            $montant =  (($qte_vendue_proteine *  $prix_vente_proteine) + ($qte_vendue_accompagnement *  $prix_vente_accompagnement) );
           
           // dd( $pp = $venteRepa->getProteine());
            if($vivres === null or $vivres === []){
                $vivre = new Vivre();
            }
            else    {
                $vivre = $vivres[0];
            }

            if ($vivre->getProteine() == null) {
                
                $venteRepa->setUser($id_user);
                $venteRepa->setMmontant($montant);
                $entityManager->persist($venteRepa);
                $entityManager->flush();
                
                
                return $this->redirectToRoute('app_vente_repas_index');
               }

            if (!$vivre->getProteine()) {
                $this->addFlash("error", "Ce vivre "  . $venteRepa->getProteine()->getNom().  " n'est pas dans le congelateur " );
                
                return $this->redirectToRoute('app_vente_repas_index');
               }
            
              elseif ( $qte_vendue_proteine > $vivre->getQteStock()) {
               $this->addFlash("error", "La quantité de " .$vivre->getProteine(). "  n'est pas suffisante pour honorer la commande" );
                return $this->redirectToRoute('app_vente_repas_index');
               }
               else
               {
                
                $venteRepa->setUser($id_user);
                $venteRepa->setMmontant($montant);
                $entityManager->persist($venteRepa);
                $entityManager->flush();
                $vivre->setQteStock($vivre->getQteStock() -  $qte_vendue_proteine);
                $entityManager->persist($vivre);
                $entityManager->flush(); 
                
               }

           
        
            return $this->redirectToRoute('app_vente_repas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vente_repas/new.html.twig', [
            'vente_repa' => $venteRepa,
            'form' => $form,
        ]);
    }



#[Route('/select/calibre/async', name: 'select_calibre_async')]

    public function getCalibreByProteine(Request $request,CalibreRepository $calibreRepository,ProteineRepository $proteineRepository) : Response
    {
        
        if($request->isXmlHttpRequest()) // Pour vérifier la présence d'une requête Ajax

        {
            $id_proteine = trim($request->request->get('id_proteine'));            
                      
            if($id_proteine != '' && $id_proteine > 0)                    
            {
                
               $proteine = $proteineRepository->findOneBy(['id'=>$id_proteine]) ;
                $calibre = $calibreRepository->findBy(['proteine'=>$proteine]);

                $html_data = '';
                
                foreach ($calibre as $key => $c) {
                    
                        $html_data.='<option value="'.$c->getId().'">'.$c->getMasse().'</option>';
                }


             
                
                return $this->json(
                    $html_data,  
                    Response::HTTP_OK
                );
            }
            else{
                return $this->json('Ce calibre n\'existe pas ', Response::HTTP_NOT_FOUND);
            }
        }
        
        return new Response(null, Response::HTTP_BAD_REQUEST);
    }



    #[Route('/select/calibre_repas/async', name: 'select_calibre_repas_async')]

    public function getCalibreByAccompagnement(Request $request,CalibreRepasRepository $calibreRepasRepository,RepasRepository $repasRepository) : Response
    {
        
        if($request->isXmlHttpRequest()) // Pour vérifier la présence d'une requête Ajax

        {
            $id_repas = trim($request->request->get('id_repas'));            
                      
            if($id_repas != '' && $id_repas > 0)                    
            {
                
                $repas = $repasRepository->findOneBy(['id'=>$id_repas]);
                $calibre_repas = $calibreRepasRepository->findBy(['repas'=>$repas]);

                $html_data = '';
                
                foreach ($calibre_repas as $key => $c) {
                    
                        $html_data.='<option value="'.$c->getId().'">'.$c->getPrix().'</option>';
                }

                return $this->json(
                    $html_data,  
                    Response::HTTP_OK
                );
            }
            else{
                return $this->json('Ce prix n\'existe pas ', Response::HTTP_NOT_FOUND);
            }
        }
        
        return new Response(null, Response::HTTP_BAD_REQUEST);
    }




    


    #[Route('/{id}', name: 'app_vente_repas_show', methods: ['GET'])]
    public function show(VenteRepas $venteRepa): Response
    {
        return $this->render('vente_repas/show.html.twig', [
            'vente_repa' => $venteRepa,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vente_repas_edit')]
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
    public function delete(ManagerRegistry $doctrine,int $id): Response
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
    public function annuler(VenteRepasRepository $venteRepasRepository, ManagerRegistry $doctrine,int $id,VivreRepository $vivreRepository): Response
    {
        $repas = $venteRepasRepository->find($id); 
        $qte_vendue = $repas->getQteVendue();
        $manager = $doctrine->getManager();
        $repas->setStatut("annuler");
        $manager->persist($repas);
        $manager->flush();


        $id_proteine = $repas->getProteine()->getId();
        $vivres = $vivreRepository->findBy(['proteine'=>$id_proteine]);

        
        if($vivres === null or $vivres === []){
            $vivre = new Vivre();
        }
        else    {
            $vivre = $vivres[0];
        }
        $manager = $doctrine->getManager();
        $vivre->setQteStock($vivre->getQteStock() +  $qte_vendue);
        $manager->persist($vivre);
        $manager->flush();
        
        return $this->redirectToRoute('app_vente_repas_index');
         
    
    }


    #[Route('/cart/empty', name: 'empty')]
    public function empty(SessionInterface $session)
    {
        $session->remove('panier');
       // $session->remove('panier2');
        return $this->redirectToRoute('app_cart');
    }
   

    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(SessionInterface $session, int $id)
    {
        
        //On récupère l'id du produit
        
        // On récupère le panier existant
        $panier = $session->get('panier', []);
        
        // On ajoute le produit dans le panier s'il n'y est pas encore
        
        // Sinon on incrémente sa quantité
        
        if(empty($panier[$id])){
            $panier[$id] = 1;
        }else{
           $panier[$id]++;
        }

        $session->set('panier', $panier);
        
        //On redirige vers la page du panier
        return $this->redirectToRoute('app_cart');
    }


    






    
}