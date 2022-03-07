<?php

namespace App\Entity;

use App\Repository\EmpleadoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=EmpleadoRepository::class)
 */
class Empleado implements UserInterface
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
     * @ORM\Column(type="boolean")
     * @var ?bool
     */
    private $docente;

    /**
     * @ORM\OneToMany(targetEntity="Llave", mappedBy="prestadaA")
     * @var Llave[]|Collection
     */
    private $llaves;

    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    private $nombreUsuario;


    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $clave;

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

    public function isDocente(): ?bool
    {
        return $this->docente;
    }

    public function setDocente(bool $docente): self
    {
        $this->docente = $docente;

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

    public function getNombreUsuario(): ?string
    {
        return $this->nombreUsuario;
    }

    public function setNombreUsuario(string $nombreUsuario): self
    {
        $this->nombreUsuario = $nombreUsuario;
        return $this;
    }

    public function getClave(): ?string
    {
        return $this->clave;
    }

    public function setClave(string $clave): self
    {
        $this->clave = $clave;
        return $this;
    }

    public function getRoles()
    {
        $roles = [
            'ROLE_USUARIO',
            'ROLE_EMPLEADO'
        ];

        if ($this->isOrdenanza()) {
            $roles[] = 'ROLE_ORDENANZA';
        }

        if ($this->isSecretario()) {
            $roles[] = 'ROLE_SECRETARIO';
        }

        if ($this->isDocente()) {
            $roles[] = 'ROLE_DOCENTE';
        }

        return $roles;
    }

    public function getPassword()
    {
        return $this->getClave();
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        return $this->getNombreUsuario();
    }

    public function eraseCredentials()
    {
    }
}
