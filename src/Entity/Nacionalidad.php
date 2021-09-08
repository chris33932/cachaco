<?php

namespace App\Entity;

use App\Repository\NacionalidadRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NacionalidadRepository::class)
 */
class Nacionalidad
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
     * @ORM\OneToMany(targetEntity=Victima::class, mappedBy="nacionalidad")
     */
    private $victimas;

    /**
     * @ORM\OneToMany(targetEntity=PresAutor::class, mappedBy="nacionalidad")
     */
    private $presAutors;

    public function __construct()
    {
        $this->victimas = new ArrayCollection();
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
     * @return Collection|Victima[]
     */
    public function getVictimas(): Collection
    {
        return $this->victimas;
    }

    public function addVictima(Victima $victima): self
    {
        if (!$this->victimas->contains($victima)) {
            $this->victimas[] = $victima;
            $victima->setNacionalidad($this);
        }

        return $this;
    }

    public function removeVictima(Victima $victima): self
    {
        if ($this->victimas->removeElement($victima)) {
            // set the owning side to null (unless already changed)
            if ($victima->getNacionalidad() === $this) {
                $victima->setNacionalidad(null);
            }
        }

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
            $presAutor->setNacionalidad($this);
        }

        return $this;
    }

    public function removePresAutor(PresAutor $presAutor): self
    {
        if ($this->presAutors->removeElement($presAutor)) {
            // set the owning side to null (unless already changed)
            if ($presAutor->getNacionalidad() === $this) {
                $presAutor->setNacionalidad(null);
            }
        }

        return $this;
    }
}
