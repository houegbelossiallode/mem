<?php

namespace App\Entity;

use App\Repository\MagasinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: MagasinRepository::class)]
#[UniqueEntity(fields: ['boisson'], message: 'Ce nom existe déjà')]
class Magasin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'magasins')]
    private ?Boisson $boisson = null;

    #[ORM\Column(length: 50,nullable:true)]
    private ?string $quantite_stock = null;

    #[ORM\Column(length: 50,nullable:true)]
    private ?string $quantite_sortir_resto = null;


    #[ORM\OneToMany(targetEntity: QuantiteAjoute::class, mappedBy: 'magasin',orphanRemoval: true, cascade: ['persist'])]
    private Collection $quantiteAjoutes;

    public function __construct()
    {
        $this->quantiteAjoutes = new ArrayCollection();
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

    public function getQuantiteStock(): ?string
    {
        return $this->quantite_stock;
    }

    public function setQuantiteStock(string $quantite_stock): static
    {
        $this->quantite_stock = $quantite_stock;

        return $this;
    }

    public function getQuantiteSortirResto(): ?string
    {
        return $this->quantite_sortir_resto;
    }

    public function setQuantiteSortirResto(string $quantite_sortir_resto): static
    {
        $this->quantite_sortir_resto = $quantite_sortir_resto;

        return $this;
    }


    /**
     * @return Collection<int, QuantiteAjoute>
     */
    public function getQuantiteAjoutes(): Collection
    {
        return $this->quantiteAjoutes;
    }

    public function addQuantiteAjoute(QuantiteAjoute $quantiteAjoute): static
    {
        if (!$this->quantiteAjoutes->contains($quantiteAjoute)) {
            $this->quantiteAjoutes->add($quantiteAjoute);
            $quantiteAjoute->setMagasin($this);
        }

        return $this;
    }

    public function removeQuantiteAjoute(QuantiteAjoute $quantiteAjoute): static
    {
        if ($this->quantiteAjoutes->removeElement($quantiteAjoute)) {
            // set the owning side to null (unless already changed)
            if ($quantiteAjoute->getMagasin() === $this) {
                $quantiteAjoute->setMagasin(null);
            }
        }

        return $this;
    }
}