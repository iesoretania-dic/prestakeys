<?php

namespace App\Entity;

use App\Repository\DepartamentoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepartamentoRepository::class)
 */
class Departamento
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var ?int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var ?string
     */
    private $descripcion;

    public function getId(): ?int
    {
        return $this->id;
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
}
