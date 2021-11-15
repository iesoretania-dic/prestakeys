<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Llave
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @var string
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=60)
     * @var string
     */
    private $descripcion;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    private $disponible;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCodigo(): string
    {
        return $this->codigo;
    }

    /**
     * @param string $codigo
     * @return Llave
     */
    public function setCodigo(string $codigo): Llave
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     * @return Llave
     */
    public function setDescripcion(string $descripcion): Llave
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDisponible(): bool
    {
        return $this->disponible;
    }

    /**
     * @param bool $disponible
     * @return Llave
     */
    public function setDisponible(bool $disponible): Llave
    {
        $this->disponible = $disponible;
        return $this;
    }
}
