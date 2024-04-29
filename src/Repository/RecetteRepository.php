<?php

namespace App\Repository;

use App\Entity\Recette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recette>
 *
 * @method Recette|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recette|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recette[]    findAll()
 * @method Recette[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recette::class);
    }

//    /**
//     * @return Recette[] Returns an array of Recette objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }


       public function getDateRecette($date)
        {
            $now = new \DateTime();
            $qb = $this->createQueryBuilder('r')
                ->select('SUM(v.montant)  AS total1','SUM(t.prix_vente)  AS total2','CONCAT(SUM(v.montant) + SUM(t.prix_vente)) AS recette')
                ->innerJoin('r.vente_boisson','v')
                ->innerJoin('r.vente_repas','t')
                ->Where('v.date =:date1')
                ->Where('t.date =:date2')
                ->setParameter('date1', $date->format('Y-m-d'))
                ->setParameter('date2', $date->format('Y-m-d'))
                ->getQuery()
                ->getSingleScalarResult();
                
                return $qb;
        }  



//    public function findOneBySomeField($value): ?Recette
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}