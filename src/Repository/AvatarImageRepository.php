<?php

namespace App\Repository;

use App\Entity\AvatarImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AvatarImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method AvatarImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method AvatarImage[]    findAll()
 * @method AvatarImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvatarImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AvatarImage::class);
    }

    // /**
    //  * @return AvatarImage[] Returns an array of AvatarImage objects
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
    public function findOneBySomeField($value): ?AvatarImage
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
