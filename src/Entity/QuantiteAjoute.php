<?php

namespace App\Entity;

use App\Repository\QuantiteAjouteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuantiteAjouteRepository::class)]
class QuantiteAjoute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'quantiteAjoutes')]
    private ?Magasin $magasin = null;

    #[ORM\Column(length: 50,nullable:true)]
    private ?string $quantite_ajoutee = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 50,nullable:true)]
    private ?string $quantite_sortir = null;

    #[ORM\ManyToOne(inversedBy: 'quantiteAjoutes')]
    private ?Vivre $vivre = null;


    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMagasin(): ?Magasin
    {
        return $this->magasin;
    }

    public function setMagasin(?Magasin $magasin): static
    {
        $this->magasin = $magasin;

        return $this;
    }

    public function getQuantiteAjoutee(): ?string
    {
        return $this->quantite_ajoutee;
    }

    public function setQuantiteAjoutee(string $quantite_ajoutee): static
    {
        $this->quantite_ajoutee = $quantite_ajoutee;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getQuantiteSortir(): ?string
    {
        return $this->quantite_sortir;
    }

    public function setQuantiteSortir(string $quantite_sortir): static
    {
        $this->quantite_sortir = $quantite_sortir;

        return $this;
    }

    public function getVivre(): ?Vivre
    {
        return $this->vivre;
    }

    public function setVivre(?Vivre $vivre): static
    {
        $this->vivre = $vivre;

        return $this;
    }
}