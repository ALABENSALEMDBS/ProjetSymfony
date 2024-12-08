<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\CategoryLivre;

/**
 * @extends ServiceEntityRepository<Livre>
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }
    //extention  
    public function findByCategory(CategoryLivre $category): array
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.category = :category')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }
    ///chercher livre
    public function findByTitle($title)
{
    return $this->createQueryBuilder('b')
                ->where('b.TitreLivre LIKE :title')
                ->setParameter('title', '%' . $title . '%')
                ->getQuery()
                ->getResult();
}


//    /**
//     * @return Livre[] Returns an array of Livre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Livre
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
