<?php

namespace App\Repository;

use App\Entity\TeamJoinRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TeamJoinRequest>
 *
 * @method TeamJoinRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeamJoinRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeamJoinRequest[]    findAll()
 * @method TeamJoinRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamJoinRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeamJoinRequest::class);
    }

//    /**
//     * @return TeamJoinRequest[] Returns an array of TeamJoinRequest objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TeamJoinRequest
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
