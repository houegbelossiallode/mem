<?php

namespace App\Repository;

use App\Entity\Congelateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Congelateur>
 *
 * @method Congelateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Congelateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Congelateur[]    findAll()
 * @method Congelateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CongelateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Congelateur::class);
    }

//    /**
//     * @return Congelateur[] Returns an array of Congelateur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }


   public function findByBoisson()
    {
        return $this->createQueryBuilder('c')
            ->select('c.qte_stock','b.Seuil','b.type','b.designation')
            ->Join('c.boisson','b')
            ->Where('c.qte_stock =:seuil')
            ->setParameter('seuil', 0)
            ->getQuery()
            ->getResult()
        ;
    }



//    public function findOneBySomeField($value): ?Congelateur
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}