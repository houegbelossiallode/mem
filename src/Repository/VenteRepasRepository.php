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
                ->select('SUM(v.montant)  AS total')
                ->where('v.statut IS NULL')
                ->andWhere('v.date =:date')
                ->setParameter('date', $now->format('Y-m-d'))
                ->getQuery()
                ->getSingleScalarResult(); 
                return $qb;
        }  


        public function getNbNumeraire()
        {
            $now = new \DateTime();
            $qb = $this->createQueryBuilder('v')
                ->select('SUM(v.montant)  AS total')
                ->where('v.statut IS NULL')
                ->Where('v.mode_paiement =:mode_paiement')
                ->andWhere('v.date =:date')
                ->setParameter('date', $now->format('Y-m-d'))
                ->setParameter('mode_paiement', 'Paiement Numéraire')
                ->getQuery()
                ->getSingleScalarResult(); 
                return $qb;
        }  



        public function getNbElectronique()
        {
            $now = new \DateTime();
            $qb = $this->createQueryBuilder('v')
                ->select('SUM(v.montant)  AS total')
                ->where('v.statut IS NULL')
                ->Where('v.mode_paiement =:mode_paiement')
                ->andWhere('v.date =:date')
                ->setParameter('date', $now->format('Y-m-d'))
                ->setParameter('mode_paiement', 'Paiement Electronique')
                ->getQuery()
                ->getSingleScalarResult(); 
                return $qb;
        }  

        
        public function unedate($date)
    {
       // $dateObj = \DateTime::createFromFormat('Y-m-d',$date);
        return $this->createQueryBuilder('v')
            ->select('r.accompagnement','p.nom','v.prix_vente','SUM(v.montant) AS total')
            ->leftJoin('v.repas','r')
            ->leftJoin('v.proteine','p')
            ->where('v.statut IS NULL')
            ->andWhere('v.date =:date')
            ->setParameter('date', $date->format('Y-m-d')) 
            ->getQuery()
            ->getResult()
        ;
    }


    public function unedatenumeraire($date)
    {
       // $dateObj = \DateTime::createFromFormat('Y-m-d',$date);
        return $this->createQueryBuilder('v')
            ->select('r.accompagnement','p.nom','v.prix_vente','SUM(v.montant) AS total')
            ->leftJoin('v.repas','r')
            ->leftJoin('v.proteine','p')
            ->where('v.statut IS NULL')
            ->Where('v.mode_paiement =:mode_paiement')
            ->andWhere('v.date =:date')
            ->setParameter('date', $date->format('Y-m-d')) 
            ->setParameter('mode_paiement', 'Paiement Numéraire')
            ->getQuery()
            ->getResult()
        ;
    }


    public function unedateelectronique($date)
    {
       // $dateObj = \DateTime::createFromFormat('Y-m-d',$date);
        return $this->createQueryBuilder('v')
            ->select('r.accompagnement','p.nom','v.prix_vente','SUM(v.montant) AS total')
            ->leftJoin('v.repas','r')
            ->leftJoin('v.proteine','p')
            ->where('v.statut IS NULL')
            ->Where('v.mode_paiement =:mode_paiement')
            ->andWhere('v.date =:date')
            ->setParameter('date', $date->format('Y-m-d')) 
            ->setParameter('mode_paiement', 'Paiement Electronique')
            ->getQuery()
            ->getResult()
        ;
    }


    
    
    public function recherche($date1,$date2,)
    {
       // $dateObj = \DateTime::createFromFormat('Y-m-d',$date);
        return $this->createQueryBuilder('v')
            ->select('r.accompagnement','p.nom','v.prix_vente','SUM(v.montant) AS total')
            ->leftJoin('v.repas','r')
            ->leftJoin('v.proteine','p')
            ->where('v.statut IS NULL')
            ->andWhere('v.date BETWEEN :date1 AND :date2')
            ->setParameter('date1', $date1->format('Y-m-d')) 
            ->setParameter('date2', $date2->format('Y-m-d')) 
            ->groupBy('r.accompagnement')
            ->getQuery()
            ->getResult()
        ;
    }



    public function recherchenumeraire($date1,$date2,)
    {
       // $dateObj = \DateTime::createFromFormat('Y-m-d',$date);
        return $this->createQueryBuilder('v')
            ->select('r.accompagnement','p.nom','v.prix_vente','SUM(v.montant) AS total')
            ->leftJoin('v.repas','r')
            ->leftJoin('v.proteine','p')
            ->where('v.statut IS NULL')
            ->Where('v.mode_paiement =:mode_paiement')
            ->andWhere('v.date BETWEEN :date1 AND :date2')
            ->setParameter('date1', $date1->format('Y-m-d')) 
            ->setParameter('date2', $date2->format('Y-m-d'))
            ->setParameter('mode_paiement', 'Paiement Numéraire') 
            ->groupBy('r.accompagnement')
            ->getQuery()
            ->getResult()
        ;
    }


    public function rechercheelectronique($date1,$date2,)
    {
       // $dateObj = \DateTime::createFromFormat('Y-m-d',$date);
        return $this->createQueryBuilder('v')
            ->select('r.accompagnement','p.nom','v.prix_vente','SUM(v.montant) AS total')
            ->leftJoin('v.repas','r')
            ->leftJoin('v.proteine','p')
            ->where('v.statut IS NULL')
            ->Where('v.mode_paiement =:mode_paiement')
            ->andWhere('v.date BETWEEN :date1 AND :date2')
            ->setParameter('date1', $date1->format('Y-m-d')) 
            ->setParameter('date2', $date2->format('Y-m-d'))
            ->setParameter('mode_paiement', 'Paiement Electronique') 
            ->groupBy('r.accompagnement')
            ->getQuery()
            ->getResult()
        ;
    }

    

    public function findByRepasAnnuler()
    {
       // $dateObj = \DateTime::createFromFormat('Y-m-d',$date);
        return $this->createQueryBuilder('v')
            ->select('r.accompagnement','(p.nom) AS name','v.prix_vente','v.qte_vendue','u.nom','v.date','v.montant')
            ->leftJoin('v.repas','r')
            ->leftJoin('v.proteine','p')
            ->leftJoin('v.user','u')
            ->where('v.statut IS NOT NULL')
            ->getQuery()
            ->getResult()
        ;
    }



    

    
    public function findByProteine()
    {
       
        return $this->createQueryBuilder('v')
            ->select('SUM(v.qte_vendue) AS nbproteine','p.nom')
            ->leftJoin('v.proteine','p')
            ->where('v.statut IS NULL')
            ->andWhere('v.proteine IS NOT NULL')
            ->groupBy('p.nom')
            ->getQuery()
            ->getResult()
        ;
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