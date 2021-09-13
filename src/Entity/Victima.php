<?php

namespace App\Entity;

use App\Repository\VictimaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VictimaRepository::class)
 */
class Victima
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column( name="nombre", type="string", length=100, nullable=true)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $apellido;

    /**
     * @ORM\ManyToOne(targetEntity=TipoDocumento::class, inversedBy="victimas")
     */
    private $tipoDocumento;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $documentoNro=-1;

    /**
     * @ORM\ManyToOne(targetEntity=Sexo::class, inversedBy="victimas")
     */
    private $sexo;

    /**
     * @ORM\ManyToOne(targetEntity=Genero::class, inversedBy="victimas")
     */
    private $genero;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $genero_otro="No corresponde";

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $edad=-1;

    /**
     * @ORM\ManyToOne(targetEntity=RangoEtario::class, inversedBy="victimas")
     */
    private $rango_etario;

    /**
     * @ORM\ManyToOne(targetEntity=EdadLegal::class, inversedBy="victimas")
     */
    private $edad_legal;

    /**
     * @ORM\ManyToOne(targetEntity=Nacionalidad::class, inversedBy="victimas")
     */
    private $nacionalidad;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $nacionalidad_otra="No corresponde";

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $barrio="Sin datos";

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $calle="Sin datos";

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $altura="Sin datos";

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $interseccion;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $calle_interseccion="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=RepGeografica::class, inversedBy="victimas")
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
     * @ORM\ManyToOne(targetEntity=EstadoCivil::class, inversedBy="victimas")
     */
    private $estado_civil;

    /**
     * @ORM\ManyToOne(targetEntity=MecanismoMuerte::class, inversedBy="victimas")
     */
    private $mecanismo_muerte;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $mecanismo_muerte_otro="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=TipoArma::class, inversedBy="victimas")
     */
    private $tipo_arma;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $tipo_arma_otro="No corresponde";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $medida_protecc_vigente;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $medida_protecc_especif="No corresponde";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $discapacidad="Sin datos";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $embarazada="No corresponde";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $privada_libertad="No corresponde";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ejer_prostitucion="No corresponde";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $migrante_internacional="No corresponde";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $migrante_intraprov="Sin datos";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $migrante_interprov="Sin datos";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $pueblo_originario;

    /**
     * @ORM\ManyToOne(targetEntity=Etnia::class, inversedBy="victimas")
     */
    private $etnia;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $etnia_otro="No corresponde";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $hab_nativo_esp="Si";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $homosex_bisex="No corresponde";

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $ref_activista="No corresponde";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $afro="No corresponde";

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $otra_sit_intersecc="Sin datos";

    /**
     * @ORM\ManyToOne(targetEntity=SituacionLaboral::class, inversedBy="victimas")
     */
    private $sit_laboral;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $otra_sit_laboral="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=CondicionActividad::class, inversedBy="victimas")
     */
    private $cond_actividad;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $hijos_pers_cargo="Sin datos";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $cant_a_cargo="Sin datos";

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $benef_ley_brisa;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $cant_benef="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=NivelInstruccion::class, inversedBy="victimas")
     */
    private $niv_inst;

    /**
     * @ORM\ManyToOne(targetEntity=NivelInstFormal::class, inversedBy="victimas")
     */
    private $niv_inst_form;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $violencia_exc="Sin datos";

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $femicidio="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=TipoFemicidio::class, inversedBy="victimas")
     */
    private $tipo_femicidio;

    /**
     * @ORM\ManyToOne(targetEntity=ContFemicida::class, inversedBy="victimas")
     */
    private $cont_femicida;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $fuerza_seg;

    /**
     * @ORM\ManyToOne(targetEntity=FuerzaSegPert::class, inversedBy="victimas")
     */
    private $fuer_seg_pert;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $otra_fuer_pert="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=EstadoPolicial::class, inversedBy="victimas")
     */
    private $est_pol;

    /**
     * @ORM\ManyToOne(targetEntity=FuncionMomHecho::class, inversedBy="victimas")
     */
    private $ejer_funcion;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $estado_intox;

    /**
     * @ORM\ManyToOne(targetEntity=EstadoIntox::class, inversedBy="victimas")
     */
    private $tipo_est_intox;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $est_intox_otro="No corresponde";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $desap_ant_hecho="No corresponde";

    /**
     * @ORM\Column(type="text", nullable=true)
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
     * @ORM\OneToMany(targetEntity=DetalleHecho::class, mappedBy="victima")
     */
    private $detalleHechos;

    public function __construct()
    {
        $this->detalleHechos = new ArrayCollection();
    }

   

    public function __toString()
    {
        return $this->apellido.'; '.$this->nombre.' || nro Documento '.$this->documentoNro.' || codigo ID: '.$this->id ;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
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
        return $this->tipoDocumento;
    }

    public function setTipoDocumento(?TipoDocumento $tipoDocumento): self
    {
        $this->tipoDocumento = $tipoDocumento;

        return $this;
    }

    public function getDocumentoNro(): ?string
    {
        return $this->documentoNro;
    }

    public function setDocumentoNro(?string $documentoNro): self
    {
        $this->documentoNro = $documentoNro;

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

    public function getRangoEtario(): ?RangoEtario
    {
        return $this->rango_etario;
    }

    public function setRangoEtario(?RangoEtario $rango_etario): self
    {
        $this->rango_etario = $rango_etario;

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

    public function getNacionalidad(): ?Nacionalidad
    {
        return $this->nacionalidad;
    }

    public function setNacionalidad(?Nacionalidad $nacionalidad): self
    {
        $this->nacionalidad = $nacionalidad;

        return $this;
    }

    public function getNacionalidadOtra(): ?string
    {
        return $this->nacionalidad_otra;
    }

    public function setNacionalidadOtra(?string $nacionalidad_otra): self
    {
        $this->nacionalidad_otra = $nacionalidad_otra;

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

    public function getEstadoCivil(): ?EstadoCivil
    {
        return $this->estado_civil;
    }

    public function setEstadoCivil(?EstadoCivil $estado_civil): self
    {
        $this->estado_civil = $estado_civil;

        return $this;
    }

    public function getMecanismoMuerte(): ?MecanismoMuerte
    {
        return $this->mecanismo_muerte;
    }

    public function setMecanismoMuerte(?MecanismoMuerte $mecanismo_muerte): self
    {
        $this->mecanismo_muerte = $mecanismo_muerte;

        return $this;
    }

    public function getMecanismoMuerteOtro(): ?string
    {
        return $this->mecanismo_muerte_otro;
    }

    public function setMecanismoMuerteOtro(?string $mecanismo_muerte_otro): self
    {
        $this->mecanismo_muerte_otro = $mecanismo_muerte_otro;

        return $this;
    }

    public function getTipoArma(): ?TipoArma
    {
        return $this->tipo_arma;
    }

    public function setTipoArma(?TipoArma $tipo_arma): self
    {
        $this->tipo_arma = $tipo_arma;

        return $this;
    }

    public function getTipoArmaOtro(): ?string
    {
        return $this->tipo_arma_otro;
    }

    public function setTipoArmaOtro(?string $tipo_arma_otro): self
    {
        $this->tipo_arma_otro = $tipo_arma_otro;

        return $this;
    }

    public function getMedidaProteccVigente(): ?string
    {
        return $this->medida_protecc_vigente;
    }

    public function setMedidaProteccVigente(?string $medida_protecc_vigente): self
    {
        $this->medida_protecc_vigente = $medida_protecc_vigente;

        return $this;
    }

    public function getMedidaProteccEspecif(): ?string
    {
        return $this->medida_protecc_especif;
    }

    public function setMedidaProteccEspecif(?string $medida_protecc_especif): self
    {
        $this->medida_protecc_especif = $medida_protecc_especif;

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

    public function getPrivadaLibertad(): ?string
    {
        return $this->privada_libertad;
    }

    public function setPrivadaLibertad(?string $privada_libertad): self
    {
        $this->privada_libertad = $privada_libertad;

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

    public function getMigranteInternacional(): ?string
    {
        return $this->migrante_internacional;
    }

    public function setMigranteInternacional(?string $migrante_internacional): self
    {
        $this->migrante_internacional = $migrante_internacional;

        return $this;
    }

    public function getMigranteIntraprov(): ?string
    {
        return $this->migrante_intraprov;
    }

    public function setMigranteIntraprov(?string $migrante_intraprov): self
    {
        $this->migrante_intraprov = $migrante_intraprov;

        return $this;
    }

    public function getMigranteInterprov(): ?string
    {
        return $this->migrante_interprov;
    }

    public function setMigranteInterprov(?string $migrante_interprov): self
    {
        $this->migrante_interprov = $migrante_interprov;

        return $this;
    }

    public function getPuebloOriginario(): ?string
    {
        return $this->pueblo_originario;
    }

    public function setPuebloOriginario(?string $pueblo_originario): self
    {
        $this->pueblo_originario = $pueblo_originario;

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

    public function getHabNativoEsp(): ?string
    {
        return $this->hab_nativo_esp;
    }

    public function setHabNativoEsp(?string $hab_nativo_esp): self
    {
        $this->hab_nativo_esp = $hab_nativo_esp;

        return $this;
    }

    public function getHomosexBisex(): ?string
    {
        return $this->homosex_bisex;
    }

    public function setHomosexBisex(?string $homosex_bisex): self
    {
        $this->homosex_bisex = $homosex_bisex;

        return $this;
    }

    public function getRefActivista(): ?string
    {
        return $this->ref_activista;
    }

    public function setRefActivista(?string $ref_activista): self
    {
        $this->ref_activista = $ref_activista;

        return $this;
    }

    public function getAfro(): ?string
    {
        return $this->afro;
    }

    public function setAfro(?string $afro): self
    {
        $this->afro = $afro;

        return $this;
    }

    public function getOtraSitIntersecc(): ?string
    {
        return $this->otra_sit_intersecc;
    }

    public function setOtraSitIntersecc(?string $otra_sit_intersecc): self
    {
        $this->otra_sit_intersecc = $otra_sit_intersecc;

        return $this;
    }

    public function getSitLaboral(): ?SituacionLaboral
    {
        return $this->sit_laboral;
    }

    public function setSitLaboral(?SituacionLaboral $sit_laboral): self
    {
        $this->sit_laboral = $sit_laboral;

        return $this;
    }

    public function getOtraSitLaboral(): ?string
    {
        return $this->otra_sit_laboral;
    }

    public function setOtraSitLaboral(?string $otra_sit_laboral): self
    {
        $this->otra_sit_laboral = $otra_sit_laboral;

        return $this;
    }

    public function getCondActividad(): ?CondicionActividad
    {
        return $this->cond_actividad;
    }

    public function setCondActividad(?CondicionActividad $cond_actividad): self
    {
        $this->cond_actividad = $cond_actividad;

        return $this;
    }

    public function getHijosPersCargo(): ?string
    {
        return $this->hijos_pers_cargo;
    }

    public function setHijosPersCargo(?string $hijos_pers_cargo): self
    {
        $this->hijos_pers_cargo = $hijos_pers_cargo;

        return $this;
    }

    public function getCantACargo(): ?string
    {
        return $this->cant_a_cargo;
    }

    public function setCantACargo(?string $cant_a_cargo): self
    {
        $this->cant_a_cargo = $cant_a_cargo;

        return $this;
    }

    public function getBenefLeyBrisa(): ?string
    {
        return $this->benef_ley_brisa;
    }

    public function setBenefLeyBrisa(?string $benef_ley_brisa): self
    {
        $this->benef_ley_brisa = $benef_ley_brisa;

        return $this;
    }

    public function getCantBenef(): ?string
    {
        return $this->cant_benef;
    }

    public function setCantBenef(?string $cant_benef): self
    {
        $this->cant_benef = $cant_benef;

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

    public function getNivInstForm(): ?NivelInstFormal
    {
        return $this->niv_inst_form;
    }

    public function setNivInstForm(?NivelInstFormal $niv_inst_form): self
    {
        $this->niv_inst_form = $niv_inst_form;

        return $this;
    }

    public function getViolenciaExc(): ?string
    {
        return $this->violencia_exc;
    }

    public function setViolenciaExc(?string $violencia_exc): self
    {
        $this->violencia_exc = $violencia_exc;

        return $this;
    }

    public function getFemicidio(): ?string
    {
        return $this->femicidio;
    }

    public function setFemicidio(?string $femicidio): self
    {
        $this->femicidio = $femicidio;

        return $this;
    }

    public function getTipoFemicidio(): ?TipoFemicidio
    {
        return $this->tipo_femicidio;
    }

    public function setTipoFemicidio(?TipoFemicidio $tipo_femicidio): self
    {
        $this->tipo_femicidio = $tipo_femicidio;

        return $this;
    }

    public function getContFemicida(): ?ContFemicida
    {
        return $this->cont_femicida;
    }

    public function setContFemicida(?ContFemicida $cont_femicida): self
    {
        $this->cont_femicida = $cont_femicida;

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

    public function getOtraFuerPert(): ?string
    {
        return $this->otra_fuer_pert;
    }

    public function setOtraFuerPert(?string $otra_fuer_pert): self
    {
        $this->otra_fuer_pert = $otra_fuer_pert;

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

    public function getEjerFuncion(): ?FuncionMomHecho
    {
        return $this->ejer_funcion;
    }

    public function setEjerFuncion(?FuncionMomHecho $ejer_funcion): self
    {
        $this->ejer_funcion = $ejer_funcion;

        return $this;
    }

    public function getSitDetencion(): ?string
    {
        return $this->sit_detencion;
    }

    public function setSitDetencion(?string $sit_detencion): self
    {
        $this->sit_detencion = $sit_detencion;

        return $this;
    }

    public function getEstadoIntox(): ?string
    {
        return $this->estado_intox;
    }

    public function setEstadoIntox(?string $estado_intox): self
    {
        $this->estado_intox = $estado_intox;

        return $this;
    }

    public function getTipoEstIntox(): ?EstadoIntox
    {
        return $this->tipo_est_intox;
    }

    public function setTipoEstIntox(?EstadoIntox $tipo_est_intox): self
    {
        $this->tipo_est_intox = $tipo_est_intox;

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

    public function getDesapAntHecho(): ?string
    {
        return $this->desap_ant_hecho;
    }

    public function setDesapAntHecho(?string $desap_ant_hecho): self
    {
        $this->desap_ant_hecho = $desap_ant_hecho;

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
            $detalleHecho->setVictima($this);
        }

        return $this;
    }

    public function removeDetalleHecho(DetalleHecho $detalleHecho): self
    {
        if ($this->detalleHechos->removeElement($detalleHecho)) {
            // set the owning side to null (unless already changed)
            if ($detalleHecho->getVictima() === $this) {
                $detalleHecho->setVictima(null);
            }
        }

        return $this;
    }
}
