<?php

namespace App\Entity;

use App\Repository\EstadoIntoxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EstadoIntoxRepository::class)
 */
class EstadoIntox
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
     * @ORM\OneToMany(targetEntity=Victima::class, mappedBy="tipo_est_intox")
     */
    private $victimas;

    /**
     * @ORM\OneToMany(targetEntity=PresAutor::class, mappedBy="tipo_est_intox")
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
            $victima->setTipoEstIntox($this);
        }

        return $this;
    }

    public function removeVictima(Victima $victima): self
    {
        if ($this->victimas->removeElement($victima)) {
            // set the owning side to null (unless already changed)
            if ($victima->getTipoEstIntox() === $this) {
                $victima->setTipoEstIntox(null);
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
            $presAutor->setTipoEstIntox($this);
        }

        return $this;
    }

    public function removePresAutor(PresAutor $presAutor): self
    {
        if ($this->presAutors->removeElement($presAutor)) {
            // set the owning side to null (unless already changed)
            if ($presAutor->getTipoEstIntox() === $this) {
                $presAutor->setTipoEstIntox(null);
            }
        }

        return $this;
    }
}
