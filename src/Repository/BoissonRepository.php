<?php

namespace App\Repository;

use App\Entity\Boisson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Boisson>
 *
 * @method Boisson|null find($id, $lockMode = null, $lockVersion = null)
 * @method Boisson|null findOneBy(array $criteria, array $orderBy = null)
 * @method Boisson[]    findAll()
 * @method Boisson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoissonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Boisson::class);
    }

//    /**
//     * @return Boisson[] Returns an array of Boisson objects
//     */
    public function findByBoissonTest()
    {
        return $this->createQueryBuilder('b')
             
             ->innerJoin('b.magasins','m')
             ->Where('m.quantite_stock = b.Seuil')
             ->getQuery()
             ->getResult()
        ;
    }




//    public function findOneBySomeField($value): ?Boisson
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}