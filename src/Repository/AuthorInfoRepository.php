<?php
/**
 * Author Info Repository.
 */

namespace App\Repository;

use App\Entity\AuthorInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * class AuthorInfoRepository.
 *
 * @extends ServiceEntityRepository<AuthorInfo>
 *
 * @method AuthorInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuthorInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuthorInfo[]    findAll()
 * @method AuthorInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorInfoRepository extends ServiceEntityRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in configuration files.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    public const PAGINATOR_ITEMS_PER_PAGE = 5;

    /**
     * construct function.
     *
     * @param ManagerRegistry $registry Manager Registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuthorInfo::class);
    }

    /**
     * Add entity.
     *
     * @param AuthorInfo $entity AuthorInfo entity
     * @param bool       $flush  flush
     */
    public function add(AuthorInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * remove entity.
     *
     * @param AuthorInfo $entity AuthorInfo entity
     * @param bool       $flush  flush
     */
    public function remove(AuthorInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Query all records.
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select('partial authorInfo.{id, name, slug}')
            ->orderBy('authorInfo.id', 'ASC');
    }

    /**
     * save entity.
     *
     * @param AuthorInfo $authorInfo Author Info entity
     */
    public function save(AuthorInfo $authorInfo): void
    {
        $this->_em->persist($authorInfo);
        $this->_em->flush();
    }

    /**
     * delete entity.
     *
     * @param AuthorInfo $authorInfo AuthorInfo entity
     */
    public function delete(AuthorInfo $authorInfo): void
    {
        $this->_em->remove($authorInfo);
        $this->_em->flush();
    }

    /**
     * Get or create new query builder.
     *
     * @param QueryBuilder|null $queryBuilder Query builder
     *
     * @return QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('authorInfo');
    }

//    /**
//     * @return AuthorInfo[] Returns an array of AuthorInfo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AuthorInfo
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
