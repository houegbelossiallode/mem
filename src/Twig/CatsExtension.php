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



     public function getVenteBoissonAnnuler() : array
     {
         return[
           new TwigFunction('cats',[$this,'getVenteAnnuler'])  
         ];
     }
     
     public function getVenteAnnuler()
     {
         
       $venteboissonannuler = $this->em->getRepository(VenteDrink::class)->findByVenteAnnuler();
             
        return $venteboissonannuler;
     }
    

     public function getVenteRepasAnnuler() : array
     {
         return[
           new TwigFunction('cats',[$this,'getRepasAnnuler'])  
         ];
     }
     
     public function getRepasAnnuler()
     {
         
       $venterepasannuler = $this->em->getRepository(VenteRepas::class)->findByRepasAnnuler();
        return $venterepasannuler;
     }
    

   




public function getSoldeBoisson() : array
{
    return[
      new TwigFunction('cats',[$this,'SoldeBoisson'])  
    ];
}


public function SoldeBoisson()
{
 $totalventeboisson = $this->em->getRepository(VenteDrink::class)->getNb();
 $totaldepenseboisson = $this->em->getRepository(DepenseAppro::class)->getNb();

 return  $soldeboisson =  $totalventeboisson  - $totaldepenseboisson;
        
}




public function getSoldeRepas() : array
{
    return[
      new TwigFunction('cats',[$this,'SoldeRepas'])  
    ];
}

public function SoldeRepas()
{
  $totalventerepas = $this->em->getRepository(VenteRepas::class)->getNb();
  $totaldepensevivre = $this->em->getRepository(DepenseVivre::class)->getNb();
  return $totalventerepas  - $totaldepensevivre;    
}


public function getTresorerieBoisson() : array
{
    return[
      new TwigFunction('cats',[$this,'TresorerieBoisson'])  
    ];
}

public function TresorerieBoisson()
{
  $tresorerie= 0;
  $totalventeboisson = $this->em->getRepository(VenteDrink::class)->countByTresorerie();
  $totaldepenseboisson = $this->em->getRepository(DepenseAppro::class)->countByTresorerie();
  $soldeboisson =  $totalventeboisson  - $totaldepenseboisson;
  return $tresorerie +=  $soldeboisson;
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



public function getRecetteNumeraire() : array
{
    return[
      new TwigFunction('cats',[$this,'RecetteNumeraire'])  
    ];
}

public function RecetteNumeraire()
{
 $totalventeboisson = $this->em->getRepository(VenteDrink::class)->getNbNumeraire();
 $totalventerepas = $this->em->getRepository(VenteRepas::class)->getNbNumeraire();
 return $totalventeboisson  + $totalventerepas;       
}



public function getRecetteElectronique() : array
{
    return[
      new TwigFunction('cats',[$this,'RecetteElectronique'])  
    ];
}

public function RecetteElectronique()
{
 $totalventeboisson = $this->em->getRepository(VenteDrink::class)->getNbElectronique();
 $totalventerepas = $this->em->getRepository(VenteRepas::class)->getNbElectronique();
 return $totalventeboisson  + $totalventerepas;
}





}