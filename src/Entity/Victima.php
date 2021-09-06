<?php

namespace App\Entity;

use App\Repository\VictimaRepository;
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
     * @ORM\Column(type="string", length=100, nullable=true)
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
    private $documentoNro;

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
    private $genero_otro;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $edad;

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
    private $nacionalidad_otra;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $barrio;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $calle;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $altura;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $interseccion;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $calle_interseccion;

    /**
     * @ORM\ManyToOne(targetEntity=RepGeografica::class, inversedBy="victimas")
     */
    private $rep_geo;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $latitud;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $longitud;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $fraccion;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $radio;

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
    private $mecanismo_muerte_otro;

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
}
