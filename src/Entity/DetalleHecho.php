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
    private $vinculo_fam_otro="No corresponde";

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $vinc_no_fam_vic;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $v_no_fam_otro_v_otro="No corresponde";

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
    private $est_intox_otro;

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
        return $this->vinc_no_fam_vic;
    }

    public function setVincNoFamOtroVic(?string $vinc_no_fam_vic): self
    {
        $this->vinc_no_fam_vic = $vinc_no_fam_vic;

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

    /**
     * Get the value of pres_autor
     */ 
    public function getPres_autor()
    {
        return $this->pres_autor;
    }

    /**
     * Set the value of pres_autor
     *
     * @return  self
     */ 
    public function setPres_autor($pres_autor)
    {
        $this->pres_autor = $pres_autor;

        return $this;
    }

    /**
     * Get the value of den_prev_desc
     */ 
    public function getDen_prev_desc()
    {
        return $this->den_prev_desc;
    }

    /**
     * Set the value of den_prev_desc
     *
     * @return  self
     */ 
    public function setDen_prev_desc($den_prev_desc)
    {
        $this->den_prev_desc = $den_prev_desc;

        return $this;
    }

    /**
     * Get the value of vinculo_fam_otro
     */ 
    public function getVinculo_fam_otro()
    {
        return $this->vinculo_fam_otro;
    }

    /**
     * Set the value of vinculo_fam_otro
     *
     * @return  self
     */ 
    public function setVinculo_fam_otro($vinculo_fam_otro)
    {
        $this->vinculo_fam_otro = $vinculo_fam_otro;

        return $this;
    }

    /**
     * Get the value of vinculo_fam_vic
     */ 
    public function getVinculo_fam_vic()
    {
        return $this->vinculo_fam_vic;
    }

    /**
     * Set the value of vinculo_fam_vic
     *
     * @return  self
     */ 
    public function setVinculo_fam_vic($vinculo_fam_vic)
    {
        $this->vinculo_fam_vic = $vinculo_fam_vic;

        return $this;
    }

    /**
     * Get the value of vinc_no_fam_vic
     */ 
    public function getVinc_no_fam_vic()
    {
        return $this->vinc_no_fam_vic;
    }

    /**
     * Set the value of vinc_no_fam_vic
     *
     * @return  self
     */ 
    public function setVinc_no_fam_vic($vinc_no_fam_vic)
    {
        $this->vinc_no_fam_vic = $vinc_no_fam_vic;

        return $this;
    }

    /**
     * Get the value of est_intox
     */ 
    public function getEst_intox()
    {
        return $this->est_intox;
    }

    /**
     * Set the value of est_intox
     *
     * @return  self
     */ 
    public function setEst_intox($est_intox)
    {
        $this->est_intox = $est_intox;

        return $this;
    }

    /**
     * Get the value of tipo_e_intox
     */ 
    public function getTipo_e_intox()
    {
        return $this->tipo_e_intox;
    }

    /**
     * Set the value of tipo_e_intox
     *
     * @return  self
     */ 
    public function setTipo_e_intox($tipo_e_intox)
    {
        $this->tipo_e_intox = $tipo_e_intox;

        return $this;
    }

    /**
     * Get the value of est_intox_otro
     */ 
    public function getEst_intox_otro()
    {
        return $this->est_intox_otro;
    }

    /**
     * Set the value of est_intox_otro
     *
     * @return  self
     */ 
    public function setEst_intox_otro($est_intox_otro)
    {
        $this->est_intox_otro = $est_intox_otro;

        return $this;
    }

    /**
     * Get the value of sit_procesal
     */ 
    public function getSit_procesal()
    {
        return $this->sit_procesal;
    }

    /**
     * Set the value of sit_procesal
     *
     * @return  self
     */ 
    public function setSit_procesal($sit_procesal)
    {
        $this->sit_procesal = $sit_procesal;

        return $this;
    }

    /**
     * Get the value of comp_hecho
     */ 
    public function getComp_hecho()
    {
        return $this->comp_hecho;
    }

    /**
     * Set the value of comp_hecho
     *
     * @return  self
     */ 
    public function setComp_hecho($comp_hecho)
    {
        $this->comp_hecho = $comp_hecho;

        return $this;
    }

    /**
     * Get the value of comp_hecho_otro
     */ 
    public function getComp_hecho_otro()
    {
        return $this->comp_hecho_otro;
    }

    /**
     * Set the value of comp_hecho_otro
     *
     * @return  self
     */ 
    public function setComp_hecho_otro($comp_hecho_otro)
    {
        $this->comp_hecho_otro = $comp_hecho_otro;

        return $this;
    }
}
