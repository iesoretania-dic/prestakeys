<?php

namespace App\Entity;

use App\Repository\EmpleadoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmpleadoRepository::class)
 */
class Empleado
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
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255)
     * @var ?string
     */
    private $apellidos;

    /**
     * @ORM\Column(type="boolean")
     * @var ?bool
     */
    private $ordenanza;

    /**
     * @ORM\Column(type="boolean")
     * @var ?bool
     */
    private $secretario;

    /**
     * @ORM\OneToMany(targetEntity="Llave", mappedBy="prestadaA")
     * @var Llave[]|Collection
     */
    private $llaves;

    public function __construct()
    {
        $this->llaves = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nombre . ' ' . $this->apellidos;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function isOrdenanza(): ?bool
    {
        return $this->ordenanza;
    }

    public function setOrdenanza(bool $ordenanza): self
    {
        $this->ordenanza = $ordenanza;

        return $this;
    }

    public function isSecretario(): ?bool
    {
        return $this->secretario;
    }

    public function setSecretario(bool $secretario): self
    {
        $this->secretario = $secretario;

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
            $llave->setPrestadaA($this);
        }

        return $this;
    }

    public function removeLlave(Llave $llave): self
    {
        if ($this->llaves->removeElement($llave)) {
            // set the owning side to null (unless already changed)
            if ($llave->getPrestadaA() === $this) {
                $llave->setPrestadaA(null);
            }
        }

        return $this;
    }
}
