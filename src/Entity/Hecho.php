<?php

namespace App\Entity;

use App\Repository\HechoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HechoRepository::class)
 */
class Hecho
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
    private $nro_preventivo;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $nro_sumario="Sin datos";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $nro_exp_jud="Sin datos";

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $juzgado="Sin datos";

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $fiscalia="Sin datos";

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $anio;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $mes;

    /**
     * @ORM\ManyToOne(targetEntity=Comisaria::class, inversedBy="hechos")
     */
    private $comisaria;

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
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $cod_loc_indec;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $gran_rcia;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $hora_ocu;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $dia_ocu;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $franja_h_seis;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $franja_h_tres;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $barrio_ocu="Sin datos";

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $calle_ocu="Sin datos";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $altura_ocu="Sin datos";

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $intersecc_ocu;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $calle_int_ocu="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=RepGeografica::class)
     */
    private $rep_geo_ocu;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $latitud_ocu="Sin datos";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $longitud_ocu="Sin datos";

    /**
     * @ORM\ManyToOne(targetEntity=Zona::class)
     */
    private $zona_ocu;

    /**
     * @ORM\ManyToOne(targetEntity=TipoEspacio::class)
     */
    private $tipo_esp_ocu;

    /**
     * @ORM\ManyToOne(targetEntity=TipoLugar::class)
     */
    private $tipo_lug_ocu;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $acceso_ocu="Sin datos";

    /**
     * @ORM\ManyToOne(targetEntity=Lugar::class)
     */
    private $lugar_ocu;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lugar_ocu_otro="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=TipoDomParticular::class)
     */
    private $dom_part_ocu;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $dom_part_otro="No corresponde";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $fraccion_ocu="Sin datos";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $radio_ocu="Sin datos";

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    private $coinc_lug_ocu;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $fecha_hgo;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $hora_hgo;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $dia_hgo;

   

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $barrio_hgo="No corresponde";

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $calle_hgo="No corresponde";

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $altura_hgo="No corresponde";

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $intersec_hgo="No corresponde";

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $calle_int_hgo="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=RepGeografica::class)
     */
    private $rep_geo_hgo;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $latitud_hgo="No corresponde";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $longitud_hgo="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=Zona::class)
     */
    private $zona_hgo;

    /**
     * @ORM\ManyToOne(targetEntity=TipoEspacio::class)
     */
    private $tipo_esp_hgo;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lug_hgo_otro="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=TipoLugar::class)
     */
    private $tipo_lug_hgo;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $acceso_hgo;

    /**
     * @ORM\ManyToOne(targetEntity=Lugar::class)
     */
    private $lugar_hgo;

    /**
     * @ORM\ManyToOne(targetEntity=TipoDomParticular::class)
     */
    private $dom_part_hgo;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $dom_part_hgo_otro="No corresponde";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $fraccion_hgo="No corresponde";

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $radio_hgo="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=OcasionDelito::class)
     */
    private $oca_delito;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $oca_delito_otro="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=OrigenRegistro::class)
     */
    private $origen_reg;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $orig_reg_otro="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=EntRecepDenuncia::class)
     */
    private $recep_den;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $recep_den_otro="No corresponde";

    /**
     * @ORM\ManyToOne(targetEntity=Tipologia::class)
     */
    private $tipologia;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $cant_victimas;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $cant_vic_col = 0;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cant_pres_autor;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $observacion;

    /**
     * @ORM\OneToMany(targetEntity=DetalleHecho::class, mappedBy="hecho" ,cascade={"persist"})
     */
    private $detalleHechos;

    /**
     * @ORM\Column(type="object")
     */
    private $creado;

    public function __construct()
    {
        $this->detalleHechos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNroPreventivo(): ?string
    {
        return $this->nro_preventivo;
    }

    public function setNroPreventivo(?string $nro_preventivo): self
    {
        $this->nro_preventivo = $nro_preventivo;

        return $this;
    }

    public function getNroSumario(): ?string
    {
        return $this->nro_sumario;
    }

    public function setNroSumario(?string $nro_sumario): self
    {
        $this->nro_sumario = $nro_sumario;

        return $this;
    }

    public function getNroExpJud(): ?string
    {
        return $this->nro_exp_jud;
    }

    public function setNroExpJud(?string $nro_exp_jud): self
    {
        $this->nro_exp_jud = $nro_exp_jud;

        return $this;
    }

    public function getJuzgado(): ?string
    {
        return $this->juzgado;
    }

    public function setJuzgado(?string $juzgado): self
    {
        $this->juzgado = $juzgado;

        return $this;
    }

    public function getFiscalia(): ?string
    {
        return $this->fiscalia;
    }

    public function setFiscalia(?string $fiscalia): self
    {
        $this->fiscalia = $fiscalia;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getAnio(): ?string
    {
        return $this->anio;
    }

    public function setAnio(?string $anio): self
    {
        $this->anio = $anio;

        return $this;
    }

    public function getMes(): ?string
    {
        return $this->mes;
    }

    public function setMes(?string $mes): self
    {
        $this->mes = $mes;

        return $this;
    }

    public function getComisaria(): ?Comisaria
    {
        return $this->comisaria;
    }

    public function setComisaria(?Comisaria $comisaria): self
    {
        $this->comisaria = $comisaria;

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

    public function getCodLocIndec(): ?string
    {
        return $this->cod_loc_indec;
    }

    public function setCodLocIndec(?string $cod_loc_indec): self
    {
        $this->cod_loc_indec = $cod_loc_indec;

        return $this;
    }

    public function getGranRcia(): ?string
    {
        return $this->gran_rcia;
    }

    public function setGranRcia(?string $gran_rcia): self
    {
        $this->gran_rcia = $gran_rcia;

        return $this;
    }

    public function getHoraOcu(): ?\DateTimeInterface
    {
        return $this->hora_ocu;
    }

    public function setHoraOcu(?\DateTimeInterface $hora_ocu): self
    {
        $this->hora_ocu = $hora_ocu;

        return $this;
    }

    public function getDiaOcu(): ?string
    {
        return $this->dia_ocu;
    }

    public function setDiaOcu(?string $dia_ocu): self
    {
        $this->dia_ocu = $dia_ocu;

        return $this;
    }

    public function getFranjaHSeis(): ?string
    {
        return $this->franja_h_seis;
    }

    public function setFranjaHSeis(?string $franja_h_seis): self
    {
        $this->franja_h_seis = $franja_h_seis;

        return $this;
    }

    public function getFranjaHTres(): ?string
    {
        return $this->franja_h_tres;
    }

    public function setFranjaHTres(?string $franja_h_tres): self
    {
        $this->franja_h_tres = $franja_h_tres;

        return $this;
    }

    public function getBarrioOcu(): ?string
    {
        return $this->barrio_ocu;
    }

    public function setBarrioOcu(?string $barrio_ocu): self
    {
        $this->barrio_ocu = $barrio_ocu;

        return $this;
    }

    public function getCalleOcu(): ?string
    {
        return $this->calle_ocu;
    }

    public function setCalleOcu(?string $calle_ocu): self
    {
        $this->calle_ocu = $calle_ocu;

        return $this;
    }

    public function getAlturaOcu(): ?string
    {
        return $this->altura_ocu;
    }

    public function setAlturaOcu(?string $altura_ocu): self
    {
        $this->altura_ocu = $altura_ocu;

        return $this;
    }

    public function getInterseccOcu(): ?string
    {
        return $this->intersecc_ocu;
    }

    public function setInterseccOcu(?string $intersecc_ocu): self
    {
        $this->intersecc_ocu = $intersecc_ocu;

        return $this;
    }

    public function getCalleIntOcu(): ?string
    {
        return $this->calle_int_ocu;
    }

    public function setCalleIntOcu(?string $calle_int_ocu): self
    {
        $this->calle_int_ocu = $calle_int_ocu;

        return $this;
    }

    public function getRepGeoOcu(): ?RepGeografica
    {
        return $this->rep_geo_ocu;
    }

    public function setRepGeoOcu(?RepGeografica $rep_geo_ocu): self
    {
        $this->rep_geo_ocu = $rep_geo_ocu;

        return $this;
    }

    public function getLatitudOcu(): ?string
    {
        return $this->latitud_ocu;
    }

    public function setLatitudOcu(?string $latitud_ocu): self
    {
        $this->latitud_ocu = $latitud_ocu;

        return $this;
    }

    public function getLongitudOcu(): ?string
    {
        return $this->longitud_ocu;
    }

    public function setLongitudOcu(?string $longitud_ocu): self
    {
        $this->longitud_ocu = $longitud_ocu;

        return $this;
    }

    public function getZonaOcu(): ?Zona
    {
        return $this->zona_ocu;
    }

    public function setZonaOcu(?Zona $zona_ocu): self
    {
        $this->zona_ocu = $zona_ocu;

        return $this;
    }

    public function getTipoEspOcu(): ?TipoEspacio
    {
        return $this->tipo_esp_ocu;
    }

    public function setTipoEspOcu(?TipoEspacio $tipo_esp_ocu): self
    {
        $this->tipo_esp_ocu = $tipo_esp_ocu;

        return $this;
    }

    public function getTipoLugOcu(): ?TipoLugar
    {
        return $this->tipo_lug_ocu;
    }

    public function setTipoLugOcu(?TipoLugar $tipo_lug_ocu): self
    {
        $this->tipo_lug_ocu = $tipo_lug_ocu;

        return $this;
    }

    public function getAccesoOcu(): ?string
    {
        return $this->acceso_ocu;
    }

    public function setAccesoOcu(?string $acceso_ocu): self
    {
        $this->acceso_ocu = $acceso_ocu;

        return $this;
    }

    public function getLugarOcu(): ?Lugar
    {
        return $this->lugar_ocu;
    }

    public function setLugarOcu(?Lugar $lugar_ocu): self
    {
        $this->lugar_ocu = $lugar_ocu;

        return $this;
    }

    public function getLugarOcuOtro(): ?string
    {
        return $this->lugar_ocu_otro;
    }

    public function setLugarOcuOtro(?string $lugar_ocu_otro): self
    {
        $this->lugar_ocu_otro = $lugar_ocu_otro;

        return $this;
    }

    public function getDomPartOcu(): ?TipoDomParticular
    {
        return $this->dom_part_ocu;
    }

    public function setDomPartOcu(?TipoDomParticular $dom_part_ocu): self
    {
        $this->dom_part_ocu = $dom_part_ocu;

        return $this;
    }

    public function getDomPartOtro(): ?string
    {
        return $this->dom_part_otro;
    }

    public function setDomPartOtro(?string $dom_part_otro): self
    {
        $this->dom_part_otro = $dom_part_otro;

        return $this;
    }

    public function getFraccionOcu(): ?string
    {
        return $this->fraccion_ocu;
    }

    public function setFraccionOcu(?string $fraccion_ocu): self
    {
        $this->fraccion_ocu = $fraccion_ocu;

        return $this;
    }

    public function getRadioOcu(): ?string
    {
        return $this->radio_ocu;
    }

    public function setRadioOcu(?string $radio_ocu): self
    {
        $this->radio_ocu = $radio_ocu;

        return $this;
    }

    public function getCoincLugOcu(): ?string
    {
        return $this->coinc_lug_ocu;
    }

    public function setCoincLugOcu(?string $coinc_lug_ocu): self
    {
        $this->coinc_lug_ocu = $coinc_lug_ocu;

        return $this;
    }

    public function getFechaHgo(): ?\DateTimeInterface
    {
        return $this->fecha_hgo;
    }

    public function setFechaHgo(?\DateTimeInterface $fecha_hgo): self
    {
        $this->fecha_hgo = $fecha_hgo;

        return $this;
    }

    public function getHoraHgo(): ?\DateTimeInterface
    {
        return $this->hora_hgo;
    }

    public function setHoraHgo(?\DateTimeInterface $hora_hgo): self
    {
        $this->hora_hgo = $hora_hgo;

        return $this;
    }

    public function getDiaHgo(): ?string
    {
        return $this->dia_hgo;
    }

    public function setDiaHgo(?string $dia_hgo): self
    {
        $this->dia_hgo = $dia_hgo;

        return $this;
    }

   

    public function getBarrioHgo(): ?string
    {
        return $this->barrio_hgo;
    }

    public function setBarrioHgo(?string $barrio_hgo): self
    {
        $this->barrio_hgo = $barrio_hgo;

        return $this;
    }

    public function getCalleHgo(): ?string
    {
        return $this->calle_hgo;
    }

    public function setCalleHgo(?string $calle_hgo): self
    {
        $this->calle_hgo = $calle_hgo;

        return $this;
    }

    public function getAlturaHgo(): ?string
    {
        return $this->altura_hgo;
    }

    public function setAlturaHgo(?string $altura_hgo): self
    {
        $this->altura_hgo = $altura_hgo;

        return $this;
    }

    public function getIntersecHgo(): ?string
    {
        return $this->intersec_hgo;
    }

    public function setIntersecHgo(?string $intersec_hgo): self
    {
        $this->intersec_hgo = $intersec_hgo;

        return $this;
    }

    public function getCalleIntHgo(): ?string
    {
        return $this->calle_int_hgo;
    }

    public function setCalleIntHgo(?string $calle_int_hgo): self
    {
        $this->calle_int_hgo = $calle_int_hgo;

        return $this;
    }

    public function getRepGeoHgo(): ?RepGeografica
    {
        return $this->rep_geo_hgo;
    }

    public function setRepGeoHgo(?RepGeografica $rep_geo_hgo): self
    {
        $this->rep_geo_hgo = $rep_geo_hgo;

        return $this;
    }

    public function getLatitudHgo(): ?string
    {
        return $this->latitud_hgo;
    }

    public function setLatitudHgo(?string $latitud_hgo): self
    {
        $this->latitud_hgo = $latitud_hgo;

        return $this;
    }

    public function getLongitudHgo(): ?string
    {
        return $this->longitud_hgo;
    }

    public function setLongitudHgo(?string $longitud_hgo): self
    {
        $this->longitud_hgo = $longitud_hgo;

        return $this;
    }

    public function getZonaHgo(): ?Zona
    {
        return $this->zona_hgo;
    }

    public function setZonaHgo(?Zona $zona_hgo): self
    {
        $this->zona_hgo = $zona_hgo;

        return $this;
    }

    public function getTipoEspHgo(): ?TipoEspacio
    {
        return $this->tipo_esp_hgo;
    }

    public function setTipoEspHgo(?TipoEspacio $tipo_esp_hgo): self
    {
        $this->tipo_esp_hgo = $tipo_esp_hgo;

        return $this;
    }

    public function getLugHgoOtro(): ?string
    {
        return $this->lug_hgo_otro;
    }

    public function setLugHgoOtro(?string $lug_hgo_otro): self
    {
        $this->lug_hgo_otro = $lug_hgo_otro;

        return $this;
    }

    public function getTipoLugHgo(): ?TipoLugar
    {
        return $this->tipo_lug_hgo;
    }

    public function setTipoLugHgo(?TipoLugar $tipo_lug_hgo): self
    {
        $this->tipo_lug_hgo = $tipo_lug_hgo;

        return $this;
    }

    public function getAccesoHgo(): ?string
    {
        return $this->acceso_hgo;
    }

    public function setAccesoHgo(?string $acceso_hgo): self
    {
        $this->acceso_hgo = $acceso_hgo;

        return $this;
    }

    public function getLugarHgo(): ?Lugar
    {
        return $this->lugar_hgo;
    }

    public function setLugarHgo(?Lugar $lugar_hgo): self
    {
        $this->lugar_hgo = $lugar_hgo;

        return $this;
    }

    public function getDomPartHgo(): ?TipoDomParticular
    {
        return $this->dom_part_hgo;
    }

    public function setDomPartHgo(?TipoDomParticular $dom_part_hgo): self
    {
        $this->dom_part_hgo = $dom_part_hgo;

        return $this;
    }

    public function getDomPartHgoOtro(): ?string
    {
        return $this->dom_part_hgo_otro;
    }

    public function setDomPartHgoOtro(?string $dom_part_hgo_otro): self
    {
        $this->dom_part_hgo_otro = $dom_part_hgo_otro;

        return $this;
    }

    public function getFraccionHgo(): ?string
    {
        return $this->fraccion_hgo;
    }

    public function setFraccionHgo(?string $fraccion_hgo): self
    {
        $this->fraccion_hgo = $fraccion_hgo;

        return $this;
    }

    public function getRadioHgo(): ?string
    {
        return $this->radio_hgo;
    }

    public function setRadioHgo(?string $radio_hgo): self
    {
        $this->radio_hgo = $radio_hgo;

        return $this;
    }

    public function getOcaDelito(): ?OcasionDelito
    {
        return $this->oca_delito;
    }

    public function setOcaDelito(?OcasionDelito $oca_delito): self
    {
        $this->oca_delito = $oca_delito;

        return $this;
    }

    public function getOcaDelitoOtro(): ?string
    {
        return $this->oca_delito_otro;
    }

    public function setOcaDelitoOtro(?string $oca_delito_otro): self
    {
        $this->oca_delito_otro = $oca_delito_otro;

        return $this;
    }

    public function getOrigenReg(): ?OrigenRegistro
    {
        return $this->origen_reg;
    }

    public function setOrigenReg(?OrigenRegistro $origen_reg): self
    {
        $this->origen_reg = $origen_reg;

        return $this;
    }

    public function getOrigRegOtro(): ?string
    {
        return $this->orig_reg_otro;
    }

    public function setOrigRegOtro(?string $orig_reg_otro): self
    {
        $this->orig_reg_otro = $orig_reg_otro;

        return $this;
    }

    public function getRecepDen(): ?EntRecepDenuncia
    {
        return $this->recep_den;
    }

    public function setRecepDen(?EntRecepDenuncia $recep_den): self
    {
        $this->recep_den = $recep_den;

        return $this;
    }

    public function getRecepDenOtro(): ?string
    {
        return $this->recep_den_otro;
    }

    public function setRecepDenOtro(?string $recep_den_otro): self
    {
        $this->recep_den_otro = $recep_den_otro;

        return $this;
    }

    public function getTipologia(): ?Tipologia
    {
        return $this->tipologia;
    }

    public function setTipologia(?Tipologia $tipologia): self
    {
        $this->tipologia = $tipologia;

        return $this;
    }

    public function getCantVictimas(): ?string
    {
        return $this->cant_victimas;
    }

    public function setCantVictimas(?string $cant_victimas): self
    {
        $this->cant_victimas = $cant_victimas;

        return $this;
    }

    public function getCantVicCol(): ?string
    {
        return $this->cant_vic_col;
    }

    public function setCantVicCol(?string $cant_vic_col): self
    {
        $this->cant_vic_col = $cant_vic_col;

        return $this;
    }

    public function getCantPresAutor(): ?int
    {
        return $this->cant_pres_autor;
    }

    public function setCantPresAutor(?int $cant_pres_autor): self
    {
        $this->cant_pres_autor = $cant_pres_autor;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

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
            $detalleHecho->setHecho($this);
        }

        return $this;
    }

    public function removeDetalleHecho(DetalleHecho $detalleHecho): self
    {
        if ($this->detalleHechos->removeElement($detalleHecho)) {
            // set the owning side to null (unless already changed)
            if ($detalleHecho->getHecho() === $this) {
                $detalleHecho->setHecho(null);
            }
        }

        return $this;
    }

    public function getCreado()
    {
        return $this->creado;
    }

    public function setCreado($creado): self
    {
        $this->creado = $creado;

        return $this;
    }
}
