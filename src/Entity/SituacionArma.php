<?php

namespace App\Entity;

use App\Repository\SituacionArmaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SituacionArmaRepository::class)
 */
class SituacionArma
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity=PresAutor::class, mappedBy="sit_arma_fue")
     */
    private $presAutors;

    public function __construct()
    {
        $this->presAutors = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getDescripcion();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection|PresAutor[]
     */
    public function getPresAutors(): Collection
    {
        return $this->presAutors;
    }

    public function addPresAutor(PresAutor $presAutor): self
    {
        if (!$this->presAutors->contains($presAutor)) {
            $this->presAutors[] = $presAutor;
            $presAutor->setSitArmaFue($this);
        }

        return $this;
    }

    public function removePresAutor(PresAutor $presAutor): self
    {
        if ($this->presAutors->removeElement($presAutor)) {
            // set the owning side to null (unless already changed)
            if ($presAutor->getSitArmaFue() === $this) {
                $presAutor->setSitArmaFue(null);
            }
        }

        return $this;
    }
}
