<?php

namespace App\Twig;

use App\Entity\DepenseAppro;
use App\Entity\DepenseVivre;
use App\Entity\User;
use App\Entity\VenteDrink;
use App\Entity\VenteRepas;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CatsExtension extends AbstractExtension
{
    private $em;
    
    public function __construct(EntityManagerInterface $em, private  Security $security)
    {
        $this->em = $em;
    }

    public function getFunctions() : array
    {
        return[
          new TwigFunction('cats',[$this,'getTotalVenteBoisson'])  
        ];
    }
    
    public function getTotalVenteBoisson()
    {
        
      $totalventeboisson = $this->em->getRepository(VenteDrink::class)->getNb();
            
       return $totalventeboisson;
    }


    public function getFunction() : array
    {
        return[
          new TwigFunction('cats',[$this,'getTotalVenteRepas'])  
        ];
    }
    
    public function getTotalVenteRepas()
    {
        
      $totalventerepas = $this->em->getRepository(VenteRepas::class)->getNb();
            
       return $totalventerepas;
    }


    public function getDepenseBoisson() : array
    {
        return[
          new TwigFunction('cats',[$this,'getTotalDepenseBoisson'])  
        ];
    }
    
    public function getTotalDepenseBoisson()
    {
        
      $totaldepenseboisson = $this->em->getRepository(DepenseAppro::class)->getNb();
            
       return $totaldepenseboisson;
    }


    public function getDepenseLait() : array
    {
        return[
          new TwigFunction('cats',[$this,'getNbLait'])  
        ];
    }
    
    public function getNbLait()
    {
        
      $totalLait = $this->em->getRepository(VenteDrink::class)->getNbLait();
            
       return $totalLait;
    }


    public function getNoms() : array
    {
        return[
          new TwigFunction('cats',[$this,'getNom'])  
        ];
    }
    
    
        public function getNom()
        {
            
        $id = $this->security->getUser();
    
        return $this->em->getRepository(User::class)->findBy(['nom'=>'ASC','id'=>$id]);
            
        }
    
        public function getRecette() : array
        {
            return[
              new TwigFunction('cats',[$this,'Recette'])  
            ];
        }
        
        
        public function Recette()
      {
         $totalventeboisson = $this->em->getRepository(VenteDrink::class)->getNb();
         $totalventerepas = $this->em->getRepository(VenteRepas::class)->getNb();
        
         return $totalventeboisson  + $totalventerepas;
                
     }


     public function getDepenseVivres() : array
     {
         return[
           new TwigFunction('cats',[$this,'getDepenseVivre'])  
         ];
     }
     
     public function getDepenseVivre()
     {
         
       $totaldepensevivre = $this->em->getRepository(DepenseVivre::class)->getNb();
             
        return $totaldepensevivre;
     }




    


    

}







?>