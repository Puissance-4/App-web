<?php

namespace App\Repository;

use App\Entity\Fraisforfaitise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Fraisforfaitise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fraisforfaitise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fraisforfaitise[]    findAll()
 * @method Fraisforfaitise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FraisForfaitiseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fraisforfaitise::class);
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
    //  * @return Fraisforfaitise[] Returns an array of Fraisforfaitise objects
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
    public function findOneBySomeField($value): ?Fraisforfaitise
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
