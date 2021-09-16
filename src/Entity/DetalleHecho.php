<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\DetalleHechoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DetalleHechoRepository::class)
 */
class DetalleHecho
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Hecho::class, inversedBy="detalleHechos")
     */
    private $hecho;

    /**
     * @ORM\ManyToOne(targetEntity=Victima::class, inversedBy="detalleHechos")
     */
    private $victima;

    /**
     * @ORM\ManyToOne(targetEntity=PresAutor::class, inversedBy="detalleHechos")
     */
    private $pres_autor;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $den_previa;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $den_prev_desc;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $vinculo;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $vinculo_familiar;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vinculo_familiar_otro="No corresponde";

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vinculo_no_familiar;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $vinculo_no_familiar_otro="No corresponde";

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $conviviente;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $est_intox;

    /**
     * @ORM\ManyToOne(targetEntity=EstadoIntox::class)
     */
    private $tipo_e_intox;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $est_intox_otro="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=SitProcesal::class)
     */
    private $sit_procesal;

    /**
     * @ORM\ManyToOne(targetEntity=CompHecho::class)
     */
    private $comp_hecho;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $comp_hecho_otro;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHecho(): ?Hecho
    {
        return $this->hecho;
    }

    public function setHecho(?Hecho $hecho): self
    {
        $this->hecho = $hecho;

        return $this;
    }

    public function getVictima(): ?Victima
    {
        return $this->victima;
    }

    public function setVictima(?Victima $victima): self
    {
        $this->victima = $victima;

        return $this;
    }





    

    public function getPresAutor(): ?PresAutor
    {
        return $this->pres_autor;
    }

    public function setPresAutor(?PresAutor $pres_autor): self
    {
        $this->pres_autor = $pres_autor;

        return $this;
    }

    public function getDenPrevia(): ?string
    {
        return $this->den_previa;
    }

    public function setDenPrevia(?string $den_previa): self
    {
        $this->den_previa = $den_previa;

        return $this;
    }

    public function getDenPrevDesc(): ?string
    {
        return $this->den_prev_desc;
    }

    public function setDenPrevDesc(?string $den_prev_desc): self
    {
        $this->den_prev_desc = $den_prev_desc;

        return $this;
    }

    public function getVinculo(): ?string
    {
        return $this->vinculo;
    }

    public function setVinculo(?string $vinculo): self
    {
        $this->vinculo = $vinculo;

        return $this;
    }

    public function getVinculoFamiliar(): ?string
    {
        return $this->vinculo_familiar;
    }

    public function setVinculoFamiliar(?string $vinculo_familiar): self
    {
        $this->vinculo_familiar = $vinculo_familiar;

        return $this;
    }

    public function getVinculoFamiliarOtro(): ?string
    {
        return $this->vinculo_familiar_otro;
    }

    public function setVinculoFamiliarOtro(?string $vinculo_familiar_otro): self
    {
        $this->vinculo_familiar_otro = $vinculo_familiar_otro;

        return $this;
    }

    public function getVinculoNoFamiliar(): ?string
    {
        return $this->vinculo_no_familiar;
    }

    public function setVinculoNoFamiliar(?string $vinculo_no_familiar): self
    {
        $this->vinculo_no_familiar = $vinculo_no_familiar;

        return $this;
    }

    public function getVinculoNoFamiliarOtro(): ?string
    {
        return $this->vinculo_no_familiar_otro;
    }

    public function setVinculoNoFamiliarOtro(?string $vinculo_no_familiar_otro): self
    {
        $this->vinculo_no_familiar_otro = $vinculo_no_familiar_otro;

        return $this;
    }

    public function getConviviente(): ?string
    {
        return $this->conviviente;
    }

    public function setConviviente(?string $conviviente): self
    {
        $this->conviviente = $conviviente;

        return $this;
    }

    public function getEstIntox(): ?string
    {
        return $this->est_intox;
    }

    public function setEstIntox(?string $est_intox): self
    {
        $this->est_intox = $est_intox;

        return $this;
    }

    public function getTipoEIntox(): ?EstadoIntox
    {
        return $this->tipo_e_intox;
    }

    public function setTipoEIntox(?EstadoIntox $tipo_e_intox): self
    {
        $this->tipo_e_intox = $tipo_e_intox;

        return $this;
    }

    public function getEstIntoxOtro(): ?string
    {
        return $this->est_intox_otro;
    }

    public function setEstIntoxOtro(?string $est_intox_otro): self
    {
        $this->est_intox_otro = $est_intox_otro;

        return $this;
    }

    public function getSitProcesal(): ?SitProcesal
    {
        return $this->sit_procesal;
    }

    public function setSitProcesal(?SitProcesal $sit_procesal): self
    {
        $this->sit_procesal = $sit_procesal;

        return $this;
    }

    public function getCompHecho(): ?CompHecho
    {
        return $this->comp_hecho;
    }

    public function setCompHecho(?CompHecho $comp_hecho): self
    {
        $this->comp_hecho = $comp_hecho;

        return $this;
    }

    public function getCompHechoOtro(): ?string
    {
        return $this->comp_hecho_otro;
    }

    public function setCompHechoOtro(?string $comp_hecho_otro): self
    {
        $this->comp_hecho_otro = $comp_hecho_otro;

        return $this;
    }

   
   
}
