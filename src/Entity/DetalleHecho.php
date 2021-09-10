<?php

namespace App\Entity;

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
     * @ORM\Column(type="text", nullable=true)
     */
    private $den_prev_desc;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $vinculo;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $vinculo_fam_vic;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vinculo_fam_otro;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vinc_no_fam_otro_vic;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $v_no_fam_otro_v_otro;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $conviviente;

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

    public function getVinculoFamVic(): ?string
    {
        return $this->vinculo_fam_vic;
    }

    public function setVinculoFamVic(?string $vinculo_fam_vic): self
    {
        $this->vinculo_fam_vic = $vinculo_fam_vic;

        return $this;
    }

    public function getVinculoFamOtro(): ?string
    {
        return $this->vinculo_fam_otro;
    }

    public function setVinculoFamOtro(?string $vinculo_fam_otro): self
    {
        $this->vinculo_fam_otro = $vinculo_fam_otro;

        return $this;
    }

    public function getVincNoFamOtroVic(): ?string
    {
        return $this->vinc_no_fam_otro_vic;
    }

    public function setVincNoFamOtroVic(?string $vinc_no_fam_otro_vic): self
    {
        $this->vinc_no_fam_otro_vic = $vinc_no_fam_otro_vic;

        return $this;
    }

    public function getVNoFamOtroVOtro(): ?string
    {
        return $this->v_no_fam_otro_v_otro;
    }

    public function setVNoFamOtroVOtro(?string $v_no_fam_otro_v_otro): self
    {
        $this->v_no_fam_otro_v_otro = $v_no_fam_otro_v_otro;

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
}
