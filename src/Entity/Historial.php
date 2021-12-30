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
}
