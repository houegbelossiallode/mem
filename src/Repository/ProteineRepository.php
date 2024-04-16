<?php

namespace App\Repository;

use App\Entity\Proteine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Proteine>
 *
 * @method Proteine|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proteine|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proteine[]    findAll()
 * @method Proteine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProteineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Proteine::class);
    }

//    /**
//     * @return Proteine[] Returns an array of Proteine objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Proteine
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
