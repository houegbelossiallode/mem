<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\CongelateurRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: CongelateurRepository::class)]
class Congelateur
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
    #[ORM\ManyToOne(inversedBy: 'congelateurs')]
    private ?Boisson $boisson = null;

    #[ORM\Column(length: 50,)]
    private ?string $qte_stock = null;

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

    public function getQteStock(): ?string
    {
        return $this->qte_stock;
    }

    public function setQteStock(string $qte_stock): static
    {
        $this->qte_stock = $qte_stock;

        return $this;
    }
}