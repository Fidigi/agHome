<?php

namespace App\Repository;

use App\Entity\Wheather;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Wheather|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wheather|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wheather[]    findAll()
 * @method Wheather[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WheatherRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Wheather::class);
    }

    // /**
    //  * @return Wheather[] Returns an array of Wheather objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Wheather
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
