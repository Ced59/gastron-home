<?php

namespace App\Repository;

use App\Entity\CommandePlat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommandePlat|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandePlat|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandePlat[]    findAll()
 * @method CommandePlat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandePlatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandePlat::class);
    }

    // /**
    //  * @return CommandePlat[] Returns an array of CommandePlat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommandePlat
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
