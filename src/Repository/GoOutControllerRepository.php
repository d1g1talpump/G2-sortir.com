<?php

namespace App\Repository;

use App\Entity\GoOutController;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method GoOutController|null find($id, $lockMode = null, $lockVersion = null)
 * @method GoOutController|null findOneBy(array $criteria, array $orderBy = null)
 * @method GoOutController[]    findAll()
 * @method GoOutController[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoOutControllerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GoOutController::class);
    }

    // /**
    //  * @return GoOutController[] Returns an array of GoOutController objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GoOutController
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
