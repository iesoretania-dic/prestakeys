<?php

namespace App\Entity;

use App\Repository\LlaveRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LlaveRepository::class)
 */
class Llave
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var ?int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @var ?string
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=60)
     * @var ?string
     */
    private $descripcion;

    /**
     * @ORM\Column(type="boolean")
     * @var ?bool
     */
    private $disponible;

    /**
     * @ORM\ManyToOne(targetEntity="Empleado", inversedBy="llaves")
     * @ORM\JoinColumn(nullable=true)
     * @var ?Empleado
     */
    private $prestadaA;

    /**
     * @ORM\ManyToOne(targetEntity="Empleado")
     * @ORM\JoinColumn(nullable=true)
     * @var ?Empleado
     */
    private $prestadaPor;

    /**
     * @ORM\ManyToOne(targetEntity="Departamento", inversedBy="llaves")
     * @ORM\JoinColumn(nullable=true)
     * @var ?Departamento
     */
    private $departamento;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;
        return $this;
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

    public function isDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): self
    {
        $this->disponible = $disponible;
        return $this;
    }

    public function getDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function getPrestadaA(): ?Empleado
    {
        return $this->prestadaA;
    }

    public function setPrestadaA(?Empleado $prestadaA): self
    {
        $this->prestadaA = $prestadaA;

        return $this;
    }

    public function getPrestadaPor(): ?Empleado
    {
        return $this->prestadaPor;
    }

    public function setPrestadaPor(?Empleado $prestadaPor): self
    {
        $this->prestadaPor = $prestadaPor;

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
}
