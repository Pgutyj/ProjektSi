<?php

/**
 * Book Tag Repository.
 */
namespace App\Repository;

use App\Entity\BookTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * class BookTagRepository
 *
 * @extends ServiceEntityRepository<BookTag>
 *
 * @method BookTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookTag[]    findAll()
 * @method BookTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookTagRepository extends ServiceEntityRepository
{
    /**
     * construct function.
     *
     * @param ManagerRegistry $registry Manager Registry
     *
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookTag::class);
    }

    /**
     * Add function.
     *
     * @param BookTag $entity BookTag entity
     *
     * @param bool    $flush  flush
     */
    public function add(BookTag $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * remove function.
     *
     * @param BookTag $entity BookTag entity
     *
     * @param bool    $flush  flush
     */
    public function remove(BookTag $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return BookTag[] Returns an array of BookTag objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BookTag
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
