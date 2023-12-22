<?php

namespace App\Entity;

use App\Repository\RegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegionRepository::class)]
class Region
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $numero = null;

    #[ORM\OneToMany(mappedBy: 'region', targetEntity: Wine::class)]
    private Collection $localisation;

    public function __construct()
    {
        $this->localisation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return Collection<int, Wine>
     */
    public function getLocalisation(): Collection
    {
        return $this->localisation;
    }

    public function addLocalisation(Wine $localisation): static
    {
        if (!$this->localisation->contains($localisation)) {
            $this->localisation->add($localisation);
            $localisation->setRegion($this);
        }

        return $this;
    }

    public function removeLocalisation(Wine $localisation): static
    {
        if ($this->localisation->removeElement($localisation)) {
            // set the owning side to null (unless already changed)
            if ($localisation->getRegion() === $this) {
                $localisation->setRegion(null);
            }
        }

        return $this;
    }
}
