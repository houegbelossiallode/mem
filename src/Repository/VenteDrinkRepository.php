<?php

namespace App\Repository;

use App\Entity\VenteDrink;
use DateTime;
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
                ->where('v.Statut IS NULL')
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
                ->where('v.Statut IS NULL')
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
            ->where('v.Statut IS NULL')
            ->andWhere('b.designation LIKE :designation')
            ->setParameter('designation', $designation ) 
            ->getQuery()
            ->getResult()
        ;
    }



    public function unedate($date)
    {
       // $dateObj = \DateTime::createFromFormat('Y-m-d',$date);
        return $this->createQueryBuilder('v')
            ->select(' b.designation','v.prix_vente','SUM(v.quantite_boisson_vendue) AS quantite','SUM(v.montant) AS total')
            ->innerJoin('v.boisson','b')
            ->where('v.Statut IS NULL')
            ->andWhere('v.date =:date')
            ->setParameter('date', $date->format('Y-m-d')) 
            ->groupBy('b.designation')
            ->having('SUM(v.montant) > 0 ')
            ->getQuery()
            ->getResult()
        ;
    }

    public function recherche($date1,$date2)
    {
       // $dateObj = \DateTime::createFromFormat('Y-m-d',$date);
        return $this->createQueryBuilder('v')
            ->select('SUM(v.montant) AS total','b.designation','b.Seuil','SUM(v.quantite_boisson_vendue) AS quantite','SUM(v.montant) AS tglobal')
            ->innerJoin('v.boisson','b')
            ->where('v.Statut IS NULL')
            ->andWhere('v.date BETWEEN :date1 AND :date2')
            ->setParameter('date1', $date1->format('Y-m-d')) 
            ->setParameter('date2', $date2->format('Y-m-d')) 
            ->groupBy('b.designation')
            ->getQuery()
            ->getResult()
        ;
    }
    


    public function findBylaitunedate($date)
    {
       // $dateObj = \DateTime::createFromFormat('Y-m-d',$date);
        return $this->createQueryBuilder('v')
            ->select(' b.designation','b.Seuil','SUM(v.quantite_boisson_vendue) AS quantite','SUM(v.montant) AS total','v.prix_vente')
            ->innerJoin('v.boisson','b')
            ->where('v.Statut IS NULL')
            ->andWhere('v.date =:date')
            ->andWhere('b.designation LIKE :designation')
            ->setParameter('designation', 'LAIT CAILLE')
            ->setParameter('date', $date->format('Y-m-d')) 
            ->groupBy('b.designation')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findBylaitdeuxdate($date1,$date2)
    {
       // $dateObj = \DateTime::createFromFormat('Y-m-d',$date);
        return $this->createQueryBuilder('v')
            ->select(' b.designation','b.Seuil','SUM(v.quantite_boisson_vendue) AS quantite','SUM(v.montant) AS total','v.prix_vente')
            ->innerJoin('v.boisson','b')
            ->where('v.Statut IS NULL')
            ->andWhere('v.date BETWEEN :date1 AND :date2')
            ->andWhere('b.designation LIKE :designation')
            ->setParameter('designation', 'LAIT CAILLE')
            ->setParameter('date1', $date1->format('Y-m-d')) 
            ->setParameter('date2', $date2->format('Y-m-d')) 
            ->groupBy('b.designation')
            ->getQuery()
            ->getResult()
        ;
    }


    public function findByVenteAnnuler()
    {
       // $dateObj = \DateTime::createFromFormat('Y-m-d',$date);
        return $this->createQueryBuilder('v')
            ->select('v.montant','b.designation','v.quantite_boisson_vendue','v.prix_vente','u.nom','v.date')
            ->innerJoin('v.boisson','b')
            ->innerJoin('v.user','u')
            ->where('v.Statut IS NOT NULL')
            ->getQuery()
            ->getResult()
        ;
    }
    


    public function countByTresorerie()
        {
            $now = new \DateTime();
            $qb = $this->createQueryBuilder('v')
                ->select('SUM(v.montant)  AS total')
                ->where('v.Statut IS NULL')
               // ->andWhere('v.date =:date')
              //  ->setParameter('date', $now->format('Y-m-d'))
                ->getQuery()
                ->getSingleScalarResult();
                
                return $qb;
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