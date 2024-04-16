<?php

namespace App\Repository;

use App\Entity\VenteRepas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VenteRepas>
 *
 * @method VenteRepas|null find($id, $lockMode = null, $lockVersion = null)
 * @method VenteRepas|null findOneBy(array $criteria, array $orderBy = null)
 * @method VenteRepas[]    findAll()
 * @method VenteRepas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VenteRepasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VenteRepas::class);
    }

//    /**
//     * @return VenteRepas[] Returns an array of VenteRepas objects
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


       public function getNb()
        {
            $now = new \DateTime();
            $qb = $this->createQueryBuilder('v')
                ->select('SUM(v.prix_vente)  AS total')
                ->andWhere('v.date =:date')
                ->setParameter('date', $now->format('Y-m-d'))
                ->getQuery()
                ->getSingleScalarResult(); 
                return $qb;
        }  


//    public function findOneBySomeField($value): ?VenteRepas
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}