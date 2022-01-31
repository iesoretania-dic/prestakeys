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
class LlaveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Llave::class);
    }

    public function findByDepartamentoOrdenadas(?Departamento $departamento) : array
    {
        $qb = $this->createQueryBuilder('l')
            ->orderBy('l.codigo');

        if ($departamento) {
            $qb
                ->where('l.departamento = :departamento')
                ->setParameter('departamento', $departamento);
        }

        return $qb
            ->getQuery()
            ->getResult();
    }
}
