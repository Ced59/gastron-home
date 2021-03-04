<?php

namespace App\Repository;

use App\Entity\Livreur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livreur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livreur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livreur[]    findAll()
 * @method Livreur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livreur::class);
    }

    /**
     * @param $idSecteur
     * @return Livreur[] Returns an array of Livreur objects
     */

    public function findByDispoAndSecteur($idSecteur)
    {
        return $this->createQueryBuilder('l')
            ->join('l.utilisateur', 'u')
            ->join('u.ville', 'v')
            ->join('v.Secteur', 's')
            ->andWhere('s.id = :val')
            ->andWhere('l.isDisponible = :bool')
            ->setParameter('bool', true)
            ->setParameter('val', $idSecteur)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Livreur
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
