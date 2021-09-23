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

    public function allEventsHomePage()
    {
        $entityManager = $this->getEntityManager();

        $dql = "select e.name,
                       e.startDate,
                       e.limitSubDate,
                       e.maxSub,
                       e.id,
                       s.label,
                       u.pseudo       
                from App\Entity\Event e 
                join App\Entity\Status s WITH s.id = e.status
                join App\Entity\User u WITH u.id = e.organiser";

        $query = $entityManager->createQuery($dql);
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
