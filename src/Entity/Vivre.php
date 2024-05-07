<?php

namespace App\Entity;

use App\Repository\VivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VivreRepository::class)]
#[UniqueEntity(fields: ['proteine'], message: 'Ce nom existe déjà')]
class Vivre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

   

    #[ORM\Column(length: 50,nullable:true)]
    private ?string $qte_stock = null;

    #[ORM\OneToMany(targetEntity: QuantiteAjoute::class, mappedBy: 'vivre')]
    private Collection $quantiteAjoutes;

    #[ORM\ManyToOne(inversedBy: 'vivres')]
    private ?Proteine $proteine = null;

    public function __construct()
    {
        $this->quantiteAjoutes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

   

    public function getQteStock(): ?string
    {
        return $this->qte_stock;
    }

    public function setQteStock(string $qte_stock): static
    {
        $this->qte_stock = $qte_stock;

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
            $quantiteAjoute->setVivre($this);
        }

        return $this;
    }

    public function removeQuantiteAjoute(QuantiteAjoute $quantiteAjoute): static
    {
        if ($this->quantiteAjoutes->removeElement($quantiteAjoute)) {
            // set the owning side to null (unless already changed)
            if ($quantiteAjoute->getVivre() === $this) {
                $quantiteAjoute->setVivre(null);
            }
        }

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
}