<?php

/**
 * PublishingHouseInfoRepository
 */
namespace App\Repository;

use App\Entity\PublishingHouseInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * class PublishingHouseInfoRepository
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
     * construct function.
     *
     * @param ManagerRegistry $registry Manager Registry
     *
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PublishingHouseInfo::class);
    }

    /**
     * Add entity.
     *
     * @param PublishingHouseInfo $entity PublishingHouseInfo entity
     *
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
     *
     * @param bool                $flush  flush
     */
    public function remove(PublishingHouseInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
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
