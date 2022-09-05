<?php

/**
 * PublishingHouseInfoRepository.
 */

namespace App\Repository;

use App\Entity\PublishingHouseInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * class PublishingHouseInfoRepository.
 *
 * @extends ServiceEntityRepository<PublishingHouseInfo>
 *
 * @method PublishingHouseInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublishingHouseInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublishingHouseInfo[]    findAll()
 * @method PublishingHouseInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublishingHouseInfoRepository extends ServiceEntityRepository
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
        parent::__construct($registry, PublishingHouseInfo::class);
    }

    /**
     * Add entity.
     *
     * @param PublishingHouseInfo $entity PublishingHouseInfo entity
     * @param bool                $flush  flush
     */
    public function add(PublishingHouseInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * remove entity.
     *
     * @param PublishingHouseInfo $entity PublishingHouseInfo entity
     * @param bool                $flush  flush
     */
    public function remove(PublishingHouseInfo $entity, bool $flush = false): void
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
            ->select('partial publishingHouseInfo.{id, name}')
            ->orderBy('publishingHouseInfo.id', 'ASC');
    }

    /**
     * save entity.
     *
     * @param PublishingHouseInfo $publishingHouseInfo Publishing House Info entity
     */
    public function save(PublishingHouseInfo $publishingHouseInfo): void
    {
        $this->_em->persist($publishingHouseInfo);
        $this->_em->flush();
    }

    /**
     * delete entity.
     *
     * @param AuthorInfo $publishingHouseInfo AuthorInfo entity
     */
    public function delete(PublishingHouseInfo $publishingHouseInfo): void
    {
        $this->_em->remove($publishingHouseInfo);
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
        return $queryBuilder ?? $this->createQueryBuilder('publishingHouseInfo');
    }
//    /**
//     * @return PublishingHouseInfo[] Returns an array of PublishingHouseInfo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PublishingHouseInfo
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
