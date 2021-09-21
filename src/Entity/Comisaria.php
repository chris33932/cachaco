<?php

namespace App\Entity;

use App\Repository\ComisariaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComisariaRepository::class)
 */
class Comisaria
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $calle;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $altura;

    /**
     * @ORM\ManyToOne(targetEntity=Localidad::class)
     */
    private $localidad;

    /**
     * @ORM\OneToMany(targetEntity=Hecho::class, mappedBy="comisaria")
     */
    private $hechos;

    public function __construct()
    {
        $this->hechos = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getLocalidad().' - '.$this->getNombre();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCalle(): ?string
    {
        return $this->calle;
    }

    public function setCalle(?string $calle): self
    {
        $this->calle = $calle;

        return $this;
    }

    public function getAltura(): ?string
    {
        return $this->altura;
    }

    public function setAltura(?string $altura): self
    {
        $this->altura = $altura;

        return $this;
    }

    public function getLocalidad(): ?Localidad
    {
        return $this->localidad;
    }

    public function setLocalidad(?Localidad $localidad): self
    {
        $this->localidad = $localidad;

        return $this;
    }

    /**
     * @return Collection|Hecho[]
     */
    public function getHechos(): Collection
    {
        return $this->hechos;
    }

    public function addHecho(Hecho $hecho): self
    {
        if (!$this->hechos->contains($hecho)) {
            $this->hechos[] = $hecho;
            $hecho->setComisaria($this);
        }

        return $this;
    }

    public function removeHecho(Hecho $hecho): self
    {
        if ($this->hechos->removeElement($hecho)) {
            // set the owning side to null (unless already changed)
            if ($hecho->getComisaria() === $this) {
                $hecho->setComisaria(null);
            }
        }

        return $this;
    }
}
