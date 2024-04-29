<?php

namespace App\Repository;

use App\Entity\Magasin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Magasin>
 *
 * @method Magasin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Magasin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Magasin[]    findAll()
 * @method Magasin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MagasinRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Magasin::class);
    }

//    /**
//     * @return Magasin[] Returns an array of Magasin objects
//     */
   public function findByBoisson()
    {
        return $this->createQueryBuilder('m')
            ->select('b.designation','m.quantite_stock')
            ->leftJoin('m.boisson','b')
            ->Where('m.quantite_stock <= b.Seuil')
        //    ->orWhere('m.quantite_stock < b.Seuil')
        //    ->setParameter('b.Seuil', 'b.Seuil')
        //    ->setParameter('Seuil', 'b.Seuil')
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Magasin
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}