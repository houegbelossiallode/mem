<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecetteRepository::class)]
class Recette
{
    
  

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'recettes')]
    private ?VenteDrink $vente_boisson = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'recettes')]
    private ?VenteRepas $vente_repas = null;

    #[ORM\Column(length: 255)]
    private ?string $montant_recette = null;

    

    public function getVenteBoisson(): ?VenteDrink
    {
        return $this->vente_boisson;
    }

    public function setVenteBoisson(?VenteDrink $vente_boisson): static
    {
        $this->vente_boisson = $vente_boisson;

        return $this;
    }

    public function getVenteRepas(): ?VenteRepas
    {
        return $this->vente_repas;
    }

    public function setVenteRepas(?VenteRepas $vente_repas): static
    {
        $this->vente_repas = $vente_repas;

        return $this;
    }

    public function getMontantRecette(): ?string
    {
        return $this->montant_recette;
    }

    public function setMontantRecette(string $montant_recette): static
    {
        $this->montant_recette = $montant_recette;

        return $this;
    }
}