<?php

namespace App\Repository;

use App\Entity\Departamento;
use App\Entity\Llave;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Departamento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Departamento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Departamento[]    findAll()
 * @method Departamento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartamentoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Departamento::class);
    }

    public function findAllOrdenados() : array
    {
        return $this->createQueryBuilder('d')
            ->orderBy('d.descripcion')
            ->getQuery()
            ->getResult();
    }

    public function findAllOrdenadosConEstadistica() : array
    {
        return $this->createQueryBuilder('d')
            ->select('d AS departamento')
            ->addSelect('COUNT(l) AS numero')
            ->addSelect('COUNT(l.prestadaA) AS prestadas')
            ->addSelect('j')
            ->join('d.llaves', 'l')
            ->leftJoin('d.jefatura', 'j')
            ->groupBy('d')
            ->getQuery()
            ->getResult();
    }
}
