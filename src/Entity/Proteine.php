<?php

namespace App\Entity;

use App\Repository\ProteineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProteineRepository::class)]
class Proteine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(targetEntity: VenteRepas::class, mappedBy: 'proteine')]
    private Collection $venteRepas;

    public function __construct()
    {
        $this->venteRepas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, VenteRepas>
     */
    public function getVenteRepas(): Collection
    {
        return $this->venteRepas;
    }

    public function addVenteRepa(VenteRepas $venteRepa): static
    {
        if (!$this->venteRepas->contains($venteRepa)) {
            $this->venteRepas->add($venteRepa);
            $venteRepa->setProteine($this);
        }

        return $this;
    }

    public function removeVenteRepa(VenteRepas $venteRepa): static
    {
        if ($this->venteRepas->removeElement($venteRepa)) {
            // set the owning side to null (unless already changed)
            if ($venteRepa->getProteine() === $this) {
                $venteRepa->setProteine(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
       return $this->nom;
    }
    
}