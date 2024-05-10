<?php

namespace App\Entity;

use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[UniqueEntity(fields: ['designation'], message: 'Ce nom existe déjà')]
class Boisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255,unique: true)]
    private ?string $designation = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\OneToMany(targetEntity: DepenseAppro::class, mappedBy: 'boisson',orphanRemoval: true, cascade: ['persist'])]
    private Collection $depenseAppros;

    #[ORM\OneToMany(targetEntity: Magasin::class, mappedBy: 'boisson',orphanRemoval: true, cascade: ['persist'])]
    private Collection $magasins;

    #[ORM\OneToMany(targetEntity: VenteDrink::class, mappedBy: 'boisson',orphanRemoval: true, cascade: ['persist'])]
    private Collection $venteDrinks;

    #[ORM\OneToMany(targetEntity: Congelateur::class, mappedBy: 'boisson',orphanRemoval: true, cascade: ['persist'])]
    private Collection $congelateurs;

    #[ORM\Column(length: 10)]
    private ?string $Seuil = null;

    public function __construct()
    {
        $this->depenseAppros = new ArrayCollection();
        
        $this->magasins = new ArrayCollection();
        $this->venteDrinks = new ArrayCollection();
        $this->congelateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, DepenseAppro>
     */
    public function getDepenseAppros(): Collection
    {
        return $this->depenseAppros;
    }

    public function addDepenseAppro(DepenseAppro $depenseAppro): static
    {
        if (!$this->depenseAppros->contains($depenseAppro)) {
            $this->depenseAppros->add($depenseAppro);
            $depenseAppro->setBoisson($this);
        }

        return $this;
    }

    public function removeDepenseAppro(DepenseAppro $depenseAppro): static
    {
        if ($this->depenseAppros->removeElement($depenseAppro)) {
            // set the owning side to null (unless already changed)
            if ($depenseAppro->getBoisson() === $this) {
                $depenseAppro->setBoisson(null);
            }
        }

        return $this;
    }

    

   
    

    /**
     * @return Collection<int, Magasin>
     */
    public function getMagasins(): Collection
    {
        return $this->magasins;
    }

    public function addMagasin(Magasin $magasin): static
    {
        if (!$this->magasins->contains($magasin)) {
            $this->magasins->add($magasin);
            $magasin->setBoisson($this);
        }

        return $this;
    }

    public function removeMagasin(Magasin $magasin): static
    {
        if ($this->magasins->removeElement($magasin)) {
            // set the owning side to null (unless already changed)
            if ($magasin->getBoisson() === $this) {
                $magasin->setBoisson(null);
            }
        }

        return $this;
    }



    public function __toString()
    {
    return $this->getDesignation();
    }

    /**
     * @return Collection<int, VenteDrink>
     */
    public function getVenteDrinks(): Collection
    {
        return $this->venteDrinks;
    }

    public function addVenteDrink(VenteDrink $venteDrink): static
    {
        if (!$this->venteDrinks->contains($venteDrink)) {
            $this->venteDrinks->add($venteDrink);
            $venteDrink->setBoisson($this);
        }

        return $this;
    }

    public function removeVenteDrink(VenteDrink $venteDrink): static
    {
        if ($this->venteDrinks->removeElement($venteDrink)) {
            // set the owning side to null (unless already changed)
            if ($venteDrink->getBoisson() === $this) {
                $venteDrink->setBoisson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Congelateur>
     */
    public function getCongelateurs(): Collection
    {
        return $this->congelateurs;
    }

    public function addCongelateur(Congelateur $congelateur): static
    {
        if (!$this->congelateurs->contains($congelateur)) {
            $this->congelateurs->add($congelateur);
            $congelateur->setBoisson($this);
        }

        return $this;
    }

    public function removeCongelateur(Congelateur $congelateur): static
    {
        if ($this->congelateurs->removeElement($congelateur)) {
            // set the owning side to null (unless already changed)
            if ($congelateur->getBoisson() === $this) {
                $congelateur->setBoisson(null);
            }
        }

        return $this;
    }

    public function getSeuil(): ?string
    {
        return $this->Seuil;
    }

    public function setSeuil(string $Seuil): static
    {
        $this->Seuil = $Seuil;

        return $this;
    }
    


    
}