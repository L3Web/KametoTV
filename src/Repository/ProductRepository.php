<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getAllProduct()
    {
        return $this->createQueryBuilder("p")
            ->orderBy("p.id")
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
    public function getClothesProduct()
    {
        return $this->createQueryBuilder("p")
            ->orderBy("p.id")
            ->where("p.category_id =1")
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
    public function getOthersProduct()
    {
        return $this->createQueryBuilder("p")
            ->orderBy("p.id")
            ->where("p.category_id =2")
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }



    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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
