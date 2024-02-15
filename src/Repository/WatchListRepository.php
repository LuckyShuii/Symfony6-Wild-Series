<?php

namespace App\Repository;

use App\Entity\WatchList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WatchList>
 *
 * @method WatchList|null find($id, $lockMode = null, $lockVersion = null)
 * @method WatchList|null findOneBy(array $criteria, array $orderBy = null)
 * @method WatchList[]    findAll()
 * @method WatchList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WatchListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WatchList::class);
    }

//    /**
//     * @return WatchList[] Returns an array of WatchList objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?WatchList
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
