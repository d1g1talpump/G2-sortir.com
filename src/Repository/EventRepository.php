<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function allEventsForHomePage()
    {
        $queryBuilder = $this->createQueryBuilder('e')
            ->andWhere("e.status BETWEEN 2 AND 6");
        $query = $queryBuilder->getQuery();
        return new Paginator($query);
    }

    public function allEventByOrganiserId($id)
    {
        $queryBuilder = $this->createQueryBuilder('e')
            ->where("e.organiser = $id");
        $query = $queryBuilder->getQuery();
        return new Paginator($query);
    }

    public function findByCampusNames()
    {
        $queryBuilder = $this->createQueryBuilder('e')
            ->leftJoin('e.campus', 'c')
            ->addSelect('c.name');
        $query = $queryBuilder->getQuery();
        return new Paginator($query);
    }

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}