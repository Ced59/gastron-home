<?php

namespace App\Repository;

use App\Entity\Plats;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Plats|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plats|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plats[]    findAll()
 * @method Plats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlatsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plats::class);
    }

     /**
      * @return Plats[] Returns an array of Plats objects
      */

    public function findByRestaurantAndPositifStock($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.restaurant = :val')
            ->andWhere('p.qte > 0')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Plats
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
