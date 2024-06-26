<?php

namespace App\Entity;

use App\Repository\RepasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RepasRepository::class)]
class Repas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[Assert\Regex(
        pattern: '/\d/',
        match: false,
        message: 'Ce champ ne doit pas contenir des chiffres'
    )]
    #[ORM\Column(length: 255)]
    private ?string $accompagnement = null;

    #[ORM\OneToMany(targetEntity: VenteRepas::class, mappedBy: 'repas')]
    private Collection $venteRepas;

    public function __construct()
    {
        $this->venteRepas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccompagnement(): ?string
    {
        return $this->accompagnement;
    }

    public function setAccompagnement(string $accompagnement): static
    {
        $this->accompagnement = $accompagnement;

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
            $venteRepa->setRepas($this);
        }

        return $this;
    }

    public function removeVenteRepa(VenteRepas $venteRepa): static
    {
        if ($this->venteRepas->removeElement($venteRepa)) {
            // set the owning side to null (unless already changed)
            if ($venteRepa->getRepas() === $this) {
                $venteRepa->setRepas(null);
            }
        }

        return $this;
    }


 public function __toString()
 {
    return $this->accompagnement;
 }




    
}