<?php

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurant[]    findAll()
 * @method Restaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }

    /**
     * @param $typeRestaurant
     * @return Restaurant[]
     */
    public function getUserAndCategorieRestaurantFromRestaurant($typeRestaurant): array
    {

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT r
            FROM App\Entity\Restaurant r
            WHERE r.categorieRestaurants == :typeRestaurant
            '
        )->setParameter('typeRestaurant', $typeRestaurant);

        // returns an array of Product objects
        return $query->getResult();
    }


// /**
//  * @return Restaurant[] Returns an array of Restaurant objects
//  */
/*
public function findByExampleField($value)
{
    return $this->createQueryBuilder('r')
        ->andWhere('r.exampleField = :val')
        ->setParameter('val', $value)
        ->orderBy('r.id', 'ASC')
        ->setMaxResults(10)
        ->getQuery()
        ->getResult()
    ;
}
*/

/*
public function findOneBySomeField($value): ?Restaurant
{
    return $this->createQueryBuilder('r')
        ->andWhere('r.exampleField = :val')
        ->setParameter('val', $value)
        ->getQuery()
        ->getOneOrNullResult()
    ;
}
*/
}
