<?php

namespace App\Repository;

use App\Entity\Vivre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vivre>
 *
 * @method Vivre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vivre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vivre[]    findAll()
 * @method Vivre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vivre::class);
    }

//    /**
//     * @return Vivre[] Returns an array of Vivre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }



   public function findByVivre()
    {
        return $this->createQueryBuilder('v')
            ->select('p.nom','v.qte_stock')
            ->Join('v.proteine','p')
            ->Where('v.qte_stock <= :Seuil')
            ->setParameter('Seuil', 3)
            ->getQuery()
            ->getResult()
        ;
    }





//    public function findOneBySomeField($value): ?Vivre
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}