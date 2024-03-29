<?php

namespace App\Repository;

use App\Entity\Tournament;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tournament>
 *
 * @method Tournament|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tournament|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tournament[]    findAll()
 * @method Tournament[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TournamentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tournament::class);
    }

    //    /**
    //     * @return Tournament[] Returns an array of Tournament objects
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

    //    public function findOneBySomeField($value): ?Tournament
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    //    public function findOneBySomeField($value): ?Tournament
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    /**
     * Récupère les tournois en fonction de la catégorie de jeu
     * @param string $category Le nom de la catégorie de jeu
     * @return Tournament[] Retourne un tableau d'objets Tournament
     */
    public function findByGameCategory($category): array
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.game', 'g')
            ->andWhere('g.name = :category')
            ->andWhere('t.visibility = true')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }

    public function findByGameCategoryAndName($category, $name): array
    {
        return $this->createQueryBuilder('t')
            ->select('t.name')
            ->innerJoin('t.game', 'g')
            ->andWhere('g.name = :category')
            ->andWhere('t.visibility = true')
            ->andWhere('t.name = :name')
            ->setParameter('category', $category)
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }

    public function findByName($name): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->getQuery()
            ->getResult();
    }
}
