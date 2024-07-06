<?php

namespace App\Repository;

use App\Entity\DepenseVivre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DepenseVivre>
 *
 * @method DepenseVivre|null find($id, $lockMode = null, $lockVersion = null)
 * @method DepenseVivre|null findOneBy(array $criteria, array $orderBy = null)
 * @method DepenseVivre[]    findAll()
 * @method DepenseVivre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepenseVivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DepenseVivre::class);
    }

//    /**
//     * @return DepenseVivre[] Returns an array of DepenseVivre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }


        public function getNb()
        {
            $now = new \DateTime();
            $qb = $this->createQueryBuilder('d')
                ->select('SUM(d.cout)  AS total')
                ->andWhere('d.date =:date')
                ->setParameter('date', $now->format('Y-m-d'))
                ->getQuery()
                ->getSingleScalarResult(); 
                return $qb;
        }  



      public function unedate($date)
   {
      // $dateObj = \DateTime::createFromFormat('Y-m-d',$date);
       return $this->createQueryBuilder('d')
        ->select(' d.designation','d.quantite','d.cout')
        ->Where('d.date =:date')
        ->setParameter('date', $date->format('Y-m-d')) 
        ->getQuery()
        ->getResult()
    ;
   }


   public function recherche($date1,$date2,)
   {
      // $dateObj = \DateTime::createFromFormat('Y-m-d',$date);
       return $this->createQueryBuilder('d')
           ->select(' d.designation','d.quantite','d.cout')
           ->Where('d.date BETWEEN :date1 AND :date2')
           ->setParameter('date1', $date1->format('Y-m-d')) 
           ->setParameter('date2', $date2->format('Y-m-d')) 
           ->getQuery()
           ->getResult()
       ;
   }


   

//    public function findOneBySomeField($value): ?DepenseVivre
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}