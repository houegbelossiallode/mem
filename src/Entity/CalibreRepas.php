<?php

namespace App\Entity;

use App\Repository\CalibreRepasRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CalibreRepasRepository::class)]
#[UniqueEntity(fields: ['repas'], message: 'Ce repas existe déjà')]
class CalibreRepas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $prix = null;

    #[ORM\ManyToOne(inversedBy: 'calibreRepas')]
    private ?Repas $repas = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

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

    public function __toString()
    {
    return $this->prix;
    }


    
}