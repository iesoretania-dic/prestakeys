<?php

namespace App\Entity;

use App\Repository\HistorialRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistorialRepository::class)
 */
class Historial
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var ?int
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @var ?\DateTimeImmutable
     */
    private $fechaHoraPrestamo;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     * @var ?\DateTimeImmutable
     */
    private $fechaHoraDevolucion;

    /**
     * @ORM\ManyToOne(targetEntity="Llave")
     * @ORM\JoinColumn(nullable=false)
     * @var ?Llave
     */
    private $llave;

    /**
     * @ORM\ManyToOne(targetEntity="Empleado")
     * @ORM\JoinColumn(nullable=false)
     * @var ?Empleado
     */
    private $prestadaA;

    /**
     * @ORM\ManyToOne(targetEntity="Empleado")
     * @ORM\JoinColumn(nullable=false)
     * @var ?Empleado
     */
    private $prestadaPor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaHoraPrestamo(): ?\DateTimeImmutable
    {
        return $this->fechaHoraPrestamo;
    }

    public function setFechaHoraPrestamo(\DateTimeImmutable $fechaHoraPrestamo): self
    {
        $this->fechaHoraPrestamo = $fechaHoraPrestamo;

        return $this;
    }

    public function getFechaHoraDevolucion(): ?\DateTimeImmutable
    {
        return $this->fechaHoraDevolucion;
    }

    public function setFechaHoraDevolucion(?\DateTimeImmutable $fechaHoraDevolucion): self
    {
        $this->fechaHoraDevolucion = $fechaHoraDevolucion;

        return $this;
    }

    public function getLlave(): ?Llave
    {
        return $this->llave;
    }

    public function setLlave(?Llave $llave): self
    {
        $this->llave = $llave;

        return $this;
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
}
