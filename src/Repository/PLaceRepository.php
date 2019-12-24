<?php

namespace App\Repository;

use App\Entity\PLace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PLace|null find($id, $lockMode = null, $lockVersion = null)
 * @method PLace|null findOneBy(array $criteria, array $orderBy = null)
 * @method PLace[]    findAll()
 * @method PLace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PLaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PLace::class);
    }

    // /**
    //  * @return PLace[] Returns an array of PLace objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PLace
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
