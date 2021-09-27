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

    public function allEventsForHomePage(): Paginator
    {
        $queryBuilder = $this->createQueryBuilder('e')
            ->andWhere("e.status BETWEEN 1 AND 6");
        $query = $queryBuilder->getQuery();
        return new Paginator($query);
    }

    public function getEventsSubscriptionEnded(): Paginator
    {
        $queryBuilder = $this->createQueryBuilder('e')
//            ->where("e.status = 2")
            ->andWhere("e.limitSubDate < CURRENT_TIMESTAMP()");

        $query = $queryBuilder->getQuery();
        return new Paginator($query);
    }

    public function getEventsJustStarted(): Paginator
    {
        $queryBuilder = $this->createQueryBuilder('e')
//            ->where("e.status = 3")
            ->andWhere("e.startDate < CURRENT_TIMESTAMP()")
            ->andWhere("DATE_ADD(e.startDate, e.duration, 'MINUTE') > CURRENT_TIMESTAMP()");

        $query = $queryBuilder->getQuery();
        return new Paginator($query);
    }

    public function getEventsJustEnded(): Paginator
    {
        $queryBuilder = $this->createQueryBuilder('e')
//            ->where("e.status = 4")
            ->andWhere("e.startDate < CURRENT_TIMESTAMP()")
            ->andWhere("DATE_ADD(e.startDate, e.duration, 'MINUTE') < CURRENT_TIMESTAMP()");

        $query = $queryBuilder->getQuery();
        return new Paginator($query);
    }


    public function getEventsToHide(): Paginator
    {
        $queryBuilder = $this->createQueryBuilder('e')
//            ->where('e.status IN(1, 6)')
            ->andWhere("DATE_ADD(DATE_ADD(e.startDate, e.duration, 'MINUTE'), 28, 'DAY') < CURRENT_TIMESTAMP()");

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
