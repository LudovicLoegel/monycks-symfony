<?php

namespace App\Repository;

use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TicketRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('t')
            ->where('t.something = :value')->setParameter('value', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findTicketProgress(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT u.username,t.title,o.time,s.name,us.username as helper
        FROM user u,user us, ticket t, offer o, skill s
        WHERE t.user_id=u.id AND t.status=o.id AND o.user_id=us.id AND s.id=t.skill_id
        AND t.status IS NOT NULL
        ORDER BY t.id ASC
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }
}
