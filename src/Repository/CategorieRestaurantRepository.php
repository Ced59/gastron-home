<?php

namespace App\Repository;

use App\Entity\CategorieRestaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategorieRestaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieRestaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieRestaurant[]    findAll()
 * @method CategorieRestaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieRestaurant::class);
    }

//    /**
//     * @return CategorieRestaurant[] Returns an array of CategorieRestaurant objects
//     */
//
//    public function findByCategorieAndSecteur($idCategorie, $idSecteur)
//    {


//        return $this->createQueryBuilder('categorieRestaurant')
//            ->join('categorieRestaurant.restaurant', 'restaurant')
//            ->andWhere('categorieRestaurant.id = :id')
////            ->andWhere('restaurant.utilisateur.ville.Secteur = :secteur')
//            ->setParameter('id', $idCategorie)
////            ->setParameter('secteur', $idSecteur)
//            ->orderBy('categorieRestaurant.id', 'ASC')
//            ->getQuery()
//            ->getResult()
//        ;
//    }


    /*
    public function findOneBySomeField($value): ?CategorieRestaurant
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
