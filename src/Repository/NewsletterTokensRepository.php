<?php

namespace App\Repository;

use App\Entity\NewsletterTokens;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NewsletterTokens>
 *
 * @method NewsletterTokens|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsletterTokens|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsletterTokens[]    findAll()
 * @method NewsletterTokens[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsletterTokensRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsletterTokens::class);
    }

//    /**
//     * @return NewsletterTokens[] Returns an array of NewsletterTokens objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NewsletterTokens
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
