<?php

namespace App\Controller;

use App\Repository\ProteineRepository;
use App\Repository\RepasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(RepasRepository $repasRepository,ProteineRepository $proteineRepository,SessionInterface $session): Response
    {
       
        
        $panier = $session->get('panier', []);

        // On initialise des variables
        $data = [];
        $total = 0;
        
        foreach($panier as $id => $qte_vendue)
        {
           
            $repas = $repasRepository->find($id);
            $proteine = $proteineRepository->find($id);
           // dd($repas);
            $data[] = [
                'proteine' => $proteine,
                'repas' => $repas,
                'qte_vendue' => $qte_vendue
            ];
            
           // $total += $plat->getPrix() * $quantity;
            
        }
        
        
        return $this->render('cart/index.html.twig', [
            'data' => $data,
             'total' => $total,
             
             
        ]);
    }



    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(SessionInterface $session, int $id)
    {
        
       
        
        //On redirige vers la page du panier
        return $this->redirectToRoute('app_cart');
    }



    #[Route('/cart/remove/{id}', name: 'remove')]
    public function remove(SessionInterface $session, int $id)
    {
        //On récupère l'id du produit
        

        // On récupère le panier existant
        $panier = $session->get('panier', []);

        // On retire le produit du panier s'il n'y a qu'1 exemplaire
        // Sinon on décrémente sa quantité
        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        $session->set('panier', $panier);
        
        //On redirige vers la page du panier
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/delete/{id}', name: 'delete')]
    public function delete(SessionInterface $session, int $id)
    {
        //On récupère l'id du produit
        

        // On récupère le panier existant
        $panier = $session->get('panier', []);

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $session->set('panier', $panier);
        
        //On redirige vers la page du panier
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/empty', name: 'empty')]
    public function empty(SessionInterface $session)
    {
        $session->remove('panier');

        return $this->redirectToRoute('app_cart');
    }
}