<?php

namespace App\Entity;

use App\Repository\DepenseApproRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepenseApproRepository::class)]
class DepenseAppro
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'depenseAppros')]
    private ?Boisson $boisson = null;

    #[ORM\Column(length: 50)]
    private ?string $quantite_achete = null;

    #[ORM\Column(length: 50)]
    private ?string $prix_unitaire = null;

    #[ORM\Column(length: 50)]
    private ?string $montant = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE,options:['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 30)]
    private ?string $nombre_trou = null;

   
    public function __construct()
    {
        $this->date = new \DateTime();
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

    public function getQuantiteAchete(): ?string
    {
        return $this->quantite_achete;
    }

    public function setQuantiteAchete(string $quantite_achete): static
    {
        $this->quantite_achete = $quantite_achete;

        return $this;
    }

    public function getPrixUnitaire(): ?string
    {
        return $this->prix_unitaire;
    }

    public function setPrixUnitaire(string $prix_unitaire): static
    {
        $this->prix_unitaire = $prix_unitaire;

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

    public function getNombreTrou(): ?string
    {
        return $this->nombre_trou;
    }

    public function setNombreTrou(string $nombre_trou): static
    {
        $this->nombre_trou = $nombre_trou;

        return $this;
    }

   
}