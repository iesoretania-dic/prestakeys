<?php

namespace App\Entity;

use App\Repository\DepartamentoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity="Llave", mappedBy="departamento")
     * @var Llave[]|Collection
     */
    private $llaves;

    /**
     * @ORM\ManyToOne(targetEntity="Empleado")
     * @ORM\JoinColumn(nullable=true)
     * @var ?Empleado
     */
    private $jefatura;

    public function __construct()
    {
        $this->llaves = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->descripcion;
    }

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

    /**
     * @return Collection|Llave[]
     */
    public function getLlaves(): Collection
    {
        return $this->llaves;
    }

    public function addLlave(Llave $llave): self
    {
        if (!$this->llaves->contains($llave)) {
            $this->llaves[] = $llave;
            $llave->setDepartamento($this);
        }

        return $this;
    }

    public function removeLlave(Llave $llave): self
    {
        if ($this->llaves->removeElement($llave)) {
            // set the owning side to null (unless already changed)
            if ($llave->getDepartamento() === $this) {
                $llave->setDepartamento(null);
            }
        }

        return $this;
    }

    public function getJefatura(): ?Empleado
    {
        return $this->jefatura;
    }

    public function setJefatura(?Empleado $jefatura): self
    {
        $this->jefatura = $jefatura;

        return $this;
    }
}
