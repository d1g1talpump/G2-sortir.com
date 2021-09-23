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

    public function allEventsPublish()
    {
        $queryBuilder = $this->createQueryBuilder('e')

            ->andWhere('e.status = 2');
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }



    public function subscribedUsers()
    {
        $queryBuilder = $this->createQueryBuilder('e')
                             ->leftJoin('e.users', 'u')
                             ->addSelect('u');
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
