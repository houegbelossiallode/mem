<?php

namespace App\Repository;

use App\Entity\CalibreRepas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CalibreRepas>
 *
 * @method CalibreRepas|null find($id, $lockMode = null, $lockVersion = null)
 * @method CalibreRepas|null findOneBy(array $criteria, array $orderBy = null)
 * @method CalibreRepas[]    findAll()
 * @method CalibreRepas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalibreRepasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CalibreRepas::class);
    }

//    /**
//     * @return CalibreRepas[] Returns an array of CalibreRepas objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CalibreRepas
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
