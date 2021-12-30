<?php

namespace App\Repository;

use App\Entity\Historial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Historial|null find($id, $lockMode = null, $lockVersion = null)
 * @method Historial|null findOneBy(array $criteria, array $orderBy = null)
 * @method Historial[]    findAll()
 * @method Historial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistorialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Historial::class);
    }
}
