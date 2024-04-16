<?php

namespace App\Entity;

use App\Repository\VenteDrinkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VenteDrinkRepository::class)]
class VenteDrink
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'venteDrinks')]
    private ?Boisson $boisson = null;

    #[ORM\Column(length: 50)]
    private ?string $prix_vente = null;

    #[ORM\Column(length: 50)]
    private ?string $quantite_boisson_vendue = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE,options:['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $date = null;


    #[ORM\Column(length: 50)]
    private ?string $montant = null;

    

    #[ORM\OneToMany(targetEntity: Recette::class, mappedBy: 'vente_boisson')]
    private Collection $recettes;

    #[ORM\Column(length: 255)]
    private ?string $Statut = null;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->recettes = new ArrayCollection();
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): static
    {
        $this->boisson = $boisson;

        return $this;
    }

    public function getPrixVente(): ?string
    {
        return $this->prix_vente;
    }

    public function setPrixVente(string $prix_vente): static
    {
        $this->prix_vente = $prix_vente;

        return $this;
    }

    public function getQuantiteBoissonVendue(): ?string
    {
        return $this->quantite_boisson_vendue;
    }

    public function setQuantiteBoissonVendue(string $quantite_boisson_vendue): static
    {
        $this->quantite_boisson_vendue = $quantite_boisson_vendue;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): static
    {
        $this->montant = $montant;

        return $this;
    }


    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }
    

    /**
     * @return Collection<int, Recette>
     */
    public function getRecettes(): Collection
    {
        return $this->recettes;
    }

    public function addRecette(Recette $recette): static
    {
        if (!$this->recettes->contains($recette)) {
            $this->recettes->add($recette);
            $recette->setVenteBoisson($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): static
    {
        if ($this->recettes->removeElement($recette)) {
            // set the owning side to null (unless already changed)
            if ($recette->getVenteBoisson() === $this) {
                $recette->setVenteBoisson(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
    return $this->getBoisson();
    }

    public function getStatut(): ?string
    {
        return $this->Statut;
    }

    public function setStatut(string $Statut): static
    {
        $this->Statut = $Statut;

        return $this;
    }
    
}