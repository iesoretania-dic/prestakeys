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
}
