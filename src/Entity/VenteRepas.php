<?php

namespace App\Entity;

use App\Repository\VenteRepasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VenteRepasRepository::class)]
class VenteRepas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

   

    #[ORM\Column(length: 50)]
    private ?string $prix_vente = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE,options:['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $date = null;
    
    #[ORM\OneToMany(targetEntity: Recette::class, mappedBy: 'vente_repas')]
    private Collection $recettes;

    #[ORM\ManyToOne(inversedBy: 'venteRepas')]
    private ?Repas $repas = null;

    #[ORM\ManyToOne(inversedBy: 'venteRepas')]
    private ?Proteine $proteine = null;

    #[ORM\Column(length: 255,nullable:true)]
    private ?string $statut = null;

    #[ORM\ManyToOne(inversedBy: 'venteRepas')]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    private ?string $qte_vendue = null;

    #[ORM\Column(length: 255)]
    private ?string $montant = null;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->recettes = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
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
            $recette->setVenteRepas($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): static
    {
        if ($this->recettes->removeElement($recette)) {
            // set the owning side to null (unless already changed)
            if ($recette->getVenteRepas() === $this) {
                $recette->setVenteRepas(null);
            }
        }

        return $this;
    }

    public function getRepas(): ?Repas
    {
        return $this->repas;
    }

    public function setRepas(?Repas $repas): static
    {
        $this->repas = $repas;

        return $this;
    }

    public function getProteine(): ?Proteine
    {
        return $this->proteine;
    }

    public function setProteine(?Proteine $proteine): static
    {
        $this->proteine = $proteine;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getQteVendue(): ?string
    {
        return $this->qte_vendue;
    }

    public function setQteVendue(string $qte_vendue): static
    {
        $this->qte_vendue = $qte_vendue;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMmontant(string $montant): static
    {
        $this->montant = $montant;

        return $this;
    }


    

    
}