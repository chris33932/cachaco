<?php

namespace App\Entity;

use App\Repository\PresAutorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=PresAutorRepository::class)
 */
class PresAutor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $apellido;

    /**
     * @ORM\ManyToOne(targetEntity=TipoDocumento::class, inversedBy="presAutors")
     */
    private $tipo_documento;

    /**
     * @ORM\Column(type="string", length=11, unique=true, nullable=true)
     */
    private $documento_nro=-1;

    /**
     * @ORM\ManyToOne(targetEntity=Sexo::class, inversedBy="presAutors")
     */
    private $sexo;

    /**
     * @ORM\ManyToOne(targetEntity=Genero::class, inversedBy="presAutors")
     */
    private $genero;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $genero_otro;

    /**
     * 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $edad=-1;

    /**
     * @ORM\ManyToOne(targetEntity=EdadLegal::class, inversedBy="presAutors")
     */
    private $edad_legal;

    /**
     * @ORM\ManyToOne(targetEntity=RangoEtario::class, inversedBy="presAutors")
     */
    private $rango_etario;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $barrio="Sin datos";

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $calle="Sin datos";

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $altura="Sin datos";    

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $interseccion;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $calle_interseccion="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=RepGeografica::class, inversedBy="presAutors")
     */
    private $rep_geo;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $latitud="Sin datos";

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $longitud="Sin datos";

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $fraccion="Sin datos";

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $radio="Sin datos";

  
    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $reincidente;

    /**
     * @ORM\ManyToOne(targetEntity=Nacionalidad::class, inversedBy="presAutors")
     */
    private $nacionalidad;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $nacionalidad_otro="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=EstadoCivil::class, inversedBy="presAutors")
     */
    private $estado_civil;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ant_penal_den;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * 
     */
    private $especif_ant="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=SituacionLaboral::class, inversedBy="presAutors")
     */
    private $sit_lab;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $otra_sit_lab="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=CondicionActividad::class, inversedBy="presAutors")
     */
    private $cond_act;

    /**
     * @ORM\ManyToOne(targetEntity=NivelInstruccion::class, inversedBy="presAutors")
     */
    private $niv_inst;

    /**
     * @ORM\ManyToOne(targetEntity=NivelInstFormal::class, inversedBy="presAutors")
     */
    private $niv_inst_formal;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $fuerza_seg;

    /**
     * @ORM\ManyToOne(targetEntity=FuerzaSegPert::class, inversedBy="presAutors")
     */
    private $fuer_seg_pert;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $otra_fuer_seg_pert="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=EstadoPolicial::class, inversedBy="presAutors")
     */
    private $est_pol;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ejer_func;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $discapacidad;

 
    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $pert_pueblo_orig;

    /**
     * @ORM\ManyToOne(targetEntity=Etnia::class, inversedBy="presAutors")
     */
    private $etnia;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $etnia_otro="No corresponde";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $hab_nat_esp;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $uso_arma_fuego;

    /**
     * @ORM\ManyToOne(targetEntity=SituacionArma::class, inversedBy="presAutors")
     */
    private $sit_arma_fue;

    /**
     * @ORM\ManyToOne(targetEntity=TipoPerArma::class, inversedBy="presAutors")
     */
    private $per_arma_fue;

   

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $observacion;

    /**
     * @ORM\ManyToOne(targetEntity=Provincia::class)
     */
    private $provincia;

    /**
     * @ORM\ManyToOne(targetEntity=Departamento::class)
     */
    private $departamento;

    /**
     * @ORM\ManyToOne(targetEntity=Localidad::class)
     */
    private $localidad;

    /**
     * @ORM\OneToMany(targetEntity=DetalleHecho::class, mappedBy="pres_autor")
     */
    private $detalleHechos;

    public function __construct()
    {
        $this->detalleHechos = new ArrayCollection();
    }

    
    public function __toString()
    {
        return $this->apellido.'; '.$this->nombre.' || codigo ID: '.$this->id;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    
    public function setNombre(?string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(?string $apellido): self
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getTipoDocumento(): ?TipoDocumento
    {
        return $this->tipo_documento;
    }

    public function setTipoDocumento(?TipoDocumento $tipo_documento): self
    {
        $this->tipo_documento = $tipo_documento;

        return $this;
    }

    public function getDocumentoNro(): ?string
    {
        return $this->documento_nro;
    }

    public function setDocumentoNro(?string $documento_nro): self
    {
        $this->documento_nro = $documento_nro;

        return $this;
    }

    public function getSexo(): ?Sexo
    {
        return $this->sexo;
    }

    public function setSexo(?Sexo $sexo): self
    {
        $this->sexo = $sexo;

        return $this;
    }

    public function getGenero(): ?Genero
    {
        return $this->genero;
    }

    public function setGenero(?Genero $genero): self
    {
        $this->genero = $genero;

        return $this;
    }

    public function getGeneroOtro(): ?string
    {
        return $this->genero_otro;
    }

    public function setGeneroOtro(?string $genero_otro): self
    {
        $this->genero_otro = $genero_otro;

        return $this;
    }

    public function getEdad(): ?int
    {
        return $this->edad;
    }

    public function setEdad(?int $edad): self
    {
        $this->edad = $edad;

        return $this;
    }

    public function getEdadLegal(): ?EdadLegal
    {
        return $this->edad_legal;
    }

    public function setEdadLegal(?EdadLegal $edad_legal): self
    {
        $this->edad_legal = $edad_legal;

        return $this;
    }

    public function getRangoEtario(): ?RangoEtario
    {
        return $this->rango_etario;
    }

    public function setRangoEtario(?RangoEtario $rango_etario): self
    {
        $this->rango_etario = $rango_etario;

        return $this;
    }

    public function getBarrio(): ?string
    {
        return $this->barrio;
    }

    public function setBarrio(?string $barrio): self
    {
        $this->barrio = $barrio;

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

    public function getInterseccion(): ?string
    {
        return $this->interseccion;
    }

    public function setInterseccion(?string $interseccion): self
    {
        $this->interseccion = $interseccion;

        return $this;
    }

    public function getCalleInterseccion(): ?string
    {
        return $this->calle_interseccion;
    }

    public function setCalleInterseccion(?string $calle_interseccion): self
    {
        $this->calle_interseccion = $calle_interseccion;

        return $this;
    }

    public function getRepGeo(): ?RepGeografica
    {
        return $this->rep_geo;
    }

    public function setRepGeo(?RepGeografica $rep_geo): self
    {
        $this->rep_geo = $rep_geo;

        return $this;
    }

    public function getLatitud(): ?string
    {
        return $this->latitud;
    }

    public function setLatitud(?string $latitud): self
    {
        $this->latitud = $latitud;

        return $this;
    }

    public function getLongitud(): ?string
    {
        return $this->longitud;
    }

    public function setLongitud(?string $longitud): self
    {
        $this->longitud = $longitud;

        return $this;
    }

    public function getFraccion(): ?string
    {
        return $this->fraccion;
    }

    public function setFraccion(?string $fraccion): self
    {
        $this->fraccion = $fraccion;

        return $this;
    }

    public function getRadio(): ?string
    {
        return $this->radio;
    }

    public function setRadio(?string $radio): self
    {
        $this->radio = $radio;

        return $this;
    }

  

    public function getReincidente(): ?string
    {
        return $this->reincidente;
    }

    public function setReincidente(?string $reincidente): self
    {
        $this->reincidente = $reincidente;

        return $this;
    }

    public function getNacionalidad(): ?Nacionalidad
    {
        return $this->nacionalidad;
    }

    public function setNacionalidad(?Nacionalidad $nacionalidad): self
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    public function getNacionalidadOtro(): ?string
    {
        return $this->nacionalidad_otro;
    }

    public function setNacionalidadOtro(?string $nacionalidad_otro): self
    {
        $this->nacionalidad_otro = $nacionalidad_otro;

        return $this;
    }

    public function getEstadoCivil(): ?EstadoCivil
    {
        return $this->estado_civil;
    }

    public function setEstadoCivil(?EstadoCivil $estado_civil): self
    {
        $this->estado_civil = $estado_civil;

        return $this;
    }

    public function getAntPenalDen(): ?string
    {
        return $this->ant_penal_den;
    }

    public function setAntPenalDen(?string $ant_penal_den): self
    {
        $this->ant_penal_den = $ant_penal_den;

        return $this;
    }

    public function getEspecifAnt(): ?string
    {
        return $this->especif_ant;
    }

    public function setEspecifAnt(?string $especif_ant): self
    {
        $this->especif_ant = $especif_ant;

        return $this;
    }

    public function getSitLab(): ?SituacionLaboral
    {
        return $this->sit_lab;
    }

    public function setSitLab(?SituacionLaboral $sit_lab): self
    {
        $this->sit_lab = $sit_lab;

        return $this;
    }

    public function getOtraSitLab(): ?string
    {
        return $this->otra_sit_lab;
    }

    public function setOtraSitLab(?string $otra_sit_lab): self
    {
        $this->otra_sit_lab = $otra_sit_lab;

        return $this;
    }

    public function getCondAct(): ?CondicionActividad
    {
        return $this->cond_act;
    }

    public function setCondAct(?CondicionActividad $cond_act): self
    {
        $this->cond_act = $cond_act;

        return $this;
    }

    public function getNivInst(): ?NivelInstruccion
    {
        return $this->niv_inst;
    }

    public function setNivInst(?NivelInstruccion $niv_inst): self
    {
        $this->niv_inst = $niv_inst;

        return $this;
    }

    public function getNivInstFormal(): ?NivelInstFormal
    {
        return $this->niv_inst_formal;
    }

    public function setNivInstFormal(?NivelInstFormal $niv_inst_formal): self
    {
        $this->niv_inst_formal = $niv_inst_formal;

        return $this;
    }

    public function getFuerzaSeg(): ?string
    {
        return $this->fuerza_seg;
    }

    public function setFuerzaSeg(?string $fuerza_seg): self
    {
        $this->fuerza_seg = $fuerza_seg;

        return $this;
    }

    public function getFuerSegPert(): ?FuerzaSegPert
    {
        return $this->fuer_seg_pert;
    }

    public function setFuerSegPert(?FuerzaSegPert $fuer_seg_pert): self
    {
        $this->fuer_seg_pert = $fuer_seg_pert;

        return $this;
    }

    public function getOtraFuerSegPert(): ?string
    {
        return $this->otra_fuer_seg_pert;
    }

    public function setOtraFuerSegPert(?string $otra_fuer_seg_pert): self
    {
        $this->otra_fuer_seg_pert = $otra_fuer_seg_pert;

        return $this;
    }

    public function getEstPol(): ?EstadoPolicial
    {
        return $this->est_pol;
    }

    public function setEstPol(?EstadoPolicial $est_pol): self
    {
        $this->est_pol = $est_pol;

        return $this;
    }

    public function getEjerFunc(): ?string
    {
        return $this->ejer_func;
    }

    public function setEjerFunc(?string $ejer_func): self
    {
        $this->ejer_func = $ejer_func;

        return $this;
    }

    public function getDiscapacidad(): ?string
    {
        return $this->discapacidad;
    }

    public function setDiscapacidad(?string $discapacidad): self
    {
        $this->discapacidad = $discapacidad;

        return $this;
    }

    public function getEmbarazada(): ?string
    {
        return $this->embarazada;
    }

    public function setEmbarazada(?string $embarazada): self
    {
        $this->embarazada = $embarazada;

        return $this;
    }

    public function getPrivLibertad(): ?string
    {
        return $this->priv_libertad;
    }

    public function setPrivLibertad(?string $priv_libertad): self
    {
        $this->priv_libertad = $priv_libertad;

        return $this;
    }

    public function getEjerProstitucion(): ?string
    {
        return $this->ejer_prostitucion;
    }

    public function setEjerProstitucion(?string $ejer_prostitucion): self
    {
        $this->ejer_prostitucion = $ejer_prostitucion;

        return $this;
    }

    public function getPertPuebloOrig(): ?string
    {
        return $this->pert_pueblo_orig;
    }

    public function setPertPuebloOrig(?string $pert_pueblo_orig): self
    {
        $this->pert_pueblo_orig = $pert_pueblo_orig;

        return $this;
    }

    public function getEtnia(): ?Etnia
    {
        return $this->etnia;
    }

    public function setEtnia(?Etnia $etnia): self
    {
        $this->etnia = $etnia;

        return $this;
    }

    public function getEtniaOtro(): ?string
    {
        return $this->etnia_otro;
    }

    public function setEtniaOtro(?string $etnia_otro): self
    {
        $this->etnia_otro = $etnia_otro;

        return $this;
    }

    public function getHabNatEsp(): ?string
    {
        return $this->hab_nat_esp;
    }

    public function setHabNatEsp(?string $hab_nat_esp): self
    {
        $this->hab_nat_esp = $hab_nat_esp;

        return $this;
    }

    public function getUsoArmaFuego(): ?string
    {
        return $this->uso_arma_fuego;
    }

    public function setUsoArmaFuego(?string $uso_arma_fuego): self
    {
        $this->uso_arma_fuego = $uso_arma_fuego;

        return $this;
    }

    public function getSitArmaFue(): ?SituacionArma
    {
        return $this->sit_arma_fue;
    }

    public function setSitArmaFue(?SituacionArma $sit_arma_fue): self
    {
        $this->sit_arma_fue = $sit_arma_fue;

        return $this;
    }

    public function getPerArmaFue(): ?TipoPerArma
    {
        return $this->per_arma_fue;
    }

    public function setPerArmaFue(?TipoPerArma $per_arma_fue): self
    {
        $this->per_arma_fue = $per_arma_fue;

        return $this;
    }

    public function getSitProcHecho(): ?SitProcesal
    {
        return $this->sit_proc_hecho;
    }

    public function setSitProcHecho(?SitProcesal $sit_proc_hecho): self
    {
        $this->sit_proc_hecho = $sit_proc_hecho;

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

    public function getObservacion(): ?string
    {
        return $this->observacion;
    }

    public function setObservacion(?string $observacion): self
    {
        $this->observacion = $observacion;

        return $this;
    }

    public function getProvincia(): ?Provincia
    {
        return $this->provincia;
    }

    public function setProvincia(?Provincia $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    public function getDepartamento(): ?Departamento
    {
        return $this->departamento;
    }

    public function setDepartamento(?Departamento $departamento): self
    {
        $this->departamento = $departamento;

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
     * @return Collection|DetalleHecho[]
     */
    public function getDetalleHechos(): Collection
    {
        return $this->detalleHechos;
    }

    public function addDetalleHecho(DetalleHecho $detalleHecho): self
    {
        if (!$this->detalleHechos->contains($detalleHecho)) {
            $this->detalleHechos[] = $detalleHecho;
            $detalleHecho->setPresAutor($this);
        }

        return $this;
    }

    public function removeDetalleHecho(DetalleHecho $detalleHecho): self
    {
        if ($this->detalleHechos->removeElement($detalleHecho)) {
            // set the owning side to null (unless already changed)
            if ($detalleHecho->getPresAutor() === $this) {
                $detalleHecho->setPresAutor(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of nombre
     */ 
    public function getNombre()
    {
        return $this->nombre;
    }

   

  

}
