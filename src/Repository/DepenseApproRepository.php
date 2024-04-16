<?php

namespace App\Repository;

use App\Entity\DepenseAppro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DepenseAppro>
 *
 * @method DepenseAppro|null find($id, $lockMode = null, $lockVersion = null)
 * @method DepenseAppro|null findOneBy(array $criteria, array $orderBy = null)
 * @method DepenseAppro[]    findAll()
 * @method DepenseAppro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepenseApproRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DepenseAppro::class);
    }

//    /**
//     * @return DepenseAppro[] Returns an array of DepenseAppro objects
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
                ->select('SUM(d.montant)  AS total')
                ->andWhere('d.date =:date')
                ->setParameter('date', $now->format('Y-m-d'))
                ->getQuery()
                ->getSingleScalarResult(); 
                return $qb;
        }  


//    public function findOneBySomeField($value): ?DepenseAppro
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}