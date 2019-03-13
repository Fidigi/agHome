<?php

namespace App\Repository;

use App\Entity\AdmList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AdmList|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdmList|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdmList[]    findAll()
 * @method AdmList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdmListRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AdmList::class);
    }

    // /**
    //  * @return AdmList[] Returns an array of AdmList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdmList
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
