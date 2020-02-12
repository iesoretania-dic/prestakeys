<?php


namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="dependencia")
 */
class Dependencia
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min=3)
     * @var string
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="Llave", mappedBy="dependencia")
     * @var Llave[]
     */
    private $llaves;

    /**
     * @ORM\ManyToMany(targetEntity="Usuario")
     * @var Usuario[]|Collection
     */
    private $responsables;

    /**
     * Dependencia constructor.
     */
    public function __construct()
    {
        $this->llaves = new ArrayCollection();
        $this->responsables = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getDescripcion();
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     * @return Dependencia
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    /**
     * @return Llave[]
     */
    public function getLlaves()
    {
        return $this->llaves;
    }

    /**
     * @param Llave[] $llaves
     * @return Dependencia
     */
    public function setLlaves($llaves)
    {
        $this->llaves = $llaves;
        return $this;
    }

    /**
     * @return Usuario[]|Collection
     */
    public function getResponsables()
    {
        return $this->responsables;
    }

    /**
     * @param Usuario[] $responsables
     * @return Dependencia
     */
    public function setResponsables($responsables)
    {
        $this->responsables = $responsables;
        return $this;
    }
}

