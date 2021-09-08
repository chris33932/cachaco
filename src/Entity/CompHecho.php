<?php

namespace App\Entity;

use App\Repository\CompHechoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompHechoRepository::class)
 */
class CompHecho
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity=PresAutor::class, mappedBy="comp_hecho")
     */
    private $presAutors;

    public function __construct()
    {
        $this->presAutors = new ArrayCollection();
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
            $presAutor->setCompHecho($this);
        }

        return $this;
    }

    public function removePresAutor(PresAutor $presAutor): self
    {
        if ($this->presAutors->removeElement($presAutor)) {
            // set the owning side to null (unless already changed)
            if ($presAutor->getCompHecho() === $this) {
                $presAutor->setCompHecho(null);
            }
        }

        return $this;
    }
}
