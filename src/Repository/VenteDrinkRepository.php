<?php

namespace App\Repository;

use App\Entity\VenteDrink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

/**
 * @extends ServiceEntityRepository<VenteDrink>
 *
 * @method VenteDrink|null find($id, $lockMode = null, $lockVersion = null)
 * @method VenteDrink|null findOneBy(array $criteria, array $orderBy = null)
 * @method VenteDrink[]    findAll()
 * @method VenteDrink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VenteDrinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VenteDrink::class);
    }

//    /**
//     * @return VenteDrink[] Returns an array of VenteDrink objects
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
                ->select('SUM(v.montant)  AS total')
                ->andWhere('v.date =:date')
                ->setParameter('date', $now->format('Y-m-d'))
                ->getQuery()
                ->getSingleScalarResult();
                
                return $qb;
        }       



        public function getNbLait()
        {
            $now = new \DateTime();
            $qb = $this->createQueryBuilder('v')
                ->select('SUM(v.montant)  AS total')
                ->innerJoin('v.boisson','b')
                ->Where('v.date =:date')
                ->andWhere('b.designation LIKE :designation')
                ->setParameter('date', $now->format('Y-m-d'))
                ->setParameter('designation', 'LAIT CAILLE')
                ->getQuery()
                ->getSingleScalarResult();
                
                return $qb;
        }  

        public function search($designation): array
    {
        return $this->createQueryBuilder('v')
            ->select('b.designation','b.Seuil','SUM(v.montant)  AS total','v.quantite_boisson_vendue')
            ->innerJoin('v.boisson','b')
            ->Where('b.designation LIKE :designation')
            ->setParameter('designation', $designation ) 
            ->getQuery()
            ->getResult()
        ;
    }
        
//    public function findOneBySomeField($value): ?VenteDrink
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}