<?php

namespace App\Entity;

use App\Repository\CalibreRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: CalibreRepository::class)]
#[UniqueEntity(fields: ['proteine'], message: 'Cette protéine existe déjà')]
class Calibre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $masse = null;

    #[ORM\ManyToOne(inversedBy: 'calibres')]
    private ?Proteine $proteine = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMasse(): ?string
    {
        return $this->masse;
    }

    public function setMasse(string $masse): static
    {
        $this->masse = $masse;

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


    public function __toString()
    {
    return $this->masse;
    }

    
}