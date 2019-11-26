<?php

namespace App\Repository;

use App\Entity\Fraishorsforfait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Fraishorsforfait|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fraishorsforfait|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fraishorsforfait[]    findAll()
 * @method Fraishorsforfait[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FraisHorsForfaitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fraishorsforfait::class);
    }


    public function findByIdFiche($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.ID_FICHE = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }
    // /**
    //  * @return Fraishorsforfait[] Returns an array of Fraishorsforfait objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fraishorsforfait
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
