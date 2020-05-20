<?php

namespace App\Repository;

use App\Entity\PostMeta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PostMeta|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostMeta|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostMeta[]    findAll()
 * @method PostMeta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostMetaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostMeta::class);
    }

    // /**
    //  * @return PostMeta[] Returns an array of PostMeta objects
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
    public function findOneBySomeField($value): ?PostMeta
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
