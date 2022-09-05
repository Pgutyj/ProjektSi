<?php

/**
 * ReservationStatusRepository.
 */

namespace App\Repository;

use App\Entity\ReservationStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * class ReservationStatusRepository.
 *
 * @extends ServiceEntityRepository<ReservationStatus>
 *
 * @method ReservationStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReservationStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReservationStatus[]    findAll()
 * @method ReservationStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationStatusRepository extends ServiceEntityRepository
{
    /**
     * construct function.
     *
     * @param ManagerRegistry $registry Manager Registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReservationStatus::class);
    }

    /**
     * Add entity.
     *
     * @param ReservationStatus $entity ReservationStatus entity
     * @param bool              $flush  flush
     */
    public function add(ReservationStatus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * remove entity.
     *
     * @param ReservationStatus $entity ReservationStatus entity
     * @param bool              $flush  flush
     */
    public function remove(ReservationStatus $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ReservationStatus[] Returns an array of ReservationStatus objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ReservationStatus
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
