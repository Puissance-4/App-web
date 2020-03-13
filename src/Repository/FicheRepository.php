<?php

namespace App\Repository;

use App\Entity\Fiche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Fiche|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fiche|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fiche[]    findAll(array $orderBy = 'f.dateCreation', 'DESC')
 * @method Fiche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FicheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fiche::class);
    }

    public function findAll()
    {
        return $this->findBy(array(), array('dateCreation' => 'DESC'));
    }

    public function findByMonth($value)
    {
        //(repositoryClass="App\Repository\FicheRepository")
        return $this->createQueryBuilder('f')
            ->andWhere('MONTH(f.dateCreation) = :val')
            ->setParameter('val', $value)
            ->orderBy('f.dateCreation', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByDate($value)
    {
        //(repositoryClass="App\Repository\FicheRepository")
        return $this->createQueryBuilder('f')
            ->andWhere('MONTH(f.dateCreation) = MONTH(:val)')
            ->andWhere('YEAR(f.dateCreation) = YEAR(:val)')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    public function test()
    {
        //Essayer avec ce site
        //https://simukti.net/blog/2012/04/05/how-to-select-year-month-day-in-doctrine2/
        return $this->createQueryBuilder('f')
            ->andWhere('f.montantRembourse>=1000')
           // ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Fiche[] Returns an array of Fiche objects
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
    public function findOneBySomeField($value): ?Fiche
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
