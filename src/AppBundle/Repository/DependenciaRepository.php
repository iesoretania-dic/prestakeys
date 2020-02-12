<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Dependencia;
use AppBundle\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class DependenciaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dependencia::class);
    }

    public function findAllOrdenadas()
    {
        return $this->createQueryBuilder('d')
            ->select('d')
            ->orderBy('d.descripcion')
            ->getQuery()
            ->getResult();
    }

    public function countByUsuarioResponsable(Usuario $usuario)
    {
        return $this->createQueryBuilder('d')
            ->select('COUNT(d)')
            ->where(':usuario MEMBER OF d.responsables')
            ->setParameter('usuario', $usuario)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
