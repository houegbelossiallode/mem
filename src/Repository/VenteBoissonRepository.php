<?php

namespace App\Repository;

use App\Entity\VenteBoisson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VenteBoisson>
 *
 * @method VenteBoisson|null find($id, $lockMode = null, $lockVersion = null)
 * @method VenteBoisson|null findOneBy(array $criteria, array $orderBy = null)
 * @method VenteBoisson[]    findAll()
 * @method VenteBoisson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VenteBoissonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VenteBoisson::class);
    }

//    /**
//     * @return VenteBoisson[] Returns an array of VenteBoisson objects
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

//    public function findOneBySomeField($value): ?VenteBoisson
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
