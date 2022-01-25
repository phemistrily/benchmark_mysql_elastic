<?php

namespace App\Repository;

use App\Entity\Dealers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Dealers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dealers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dealers[]    findAll()
 * @method Dealers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DealersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dealers::class);
    }

    // /**
    //  * @return Dealers[] Returns an array of Dealers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Dealers
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
