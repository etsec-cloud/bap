<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findLastThree() //requete personnalisé
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.id', 'ASC') 
            ->getQuery()
            ->getResult()
        ;
    }
    public function findBlogAssurance() //requete personnalisé
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.id', 'ASC') 
            ->where('c.blog = 1')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findHome(){
        $qb = $this->createQueryBuilder('a')
            ->where('a.home IS NOT NULL')
            ->orderby('a.home', 'ASC')
            ->setMaxResults(3);
        $articles = $qb->getQuery();
        return $articles->execute();
}


    // /**
    //  * @return Article[] Returns an array of Article objects
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
    public function findOneBySomeField($value): ?Article
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
