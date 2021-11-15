<?php

namespace App\Entity;

class Llave
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $codigo;

    /**
     * @var string
     */
    private $descripcion;

    /**
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
