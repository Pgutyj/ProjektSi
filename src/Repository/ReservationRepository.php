<?php
/**
 * ReservationRepository
 */
namespace App\Repository;

use App\Entity\Book;
use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * class ReservationRepository
 * @extends ServiceEntityRepository<Reservation>
 *
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
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
     *
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * Add entity.
     *
     * @param Reservation $entity Reservation entity
     *
     * @param bool        $flush  flush
     */
    public function add(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Add remove.
     *
     * @param Reservation $entity Reservation entity
     *
     * @param bool        $flush  flush
     */
    public function remove(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Query all records.
     *
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(): QueryBuilder
    {
        return $this->getOrCreateQueryBuilder()
            ->select(
                'partial reservation.{id, email, reservationTime, comment}',
                'partial book.{id, title}',
                'partial reservationStatus.{id, statusInfo}',
            )
            ->join('reservation.book', 'book')
            ->join('reservation.reservationStatus', 'reservationStatus')
            ->orderBy('reservation.id', 'ASC');
    }

    /**
     * save entity.
     *
     * @param Reservation $reservation Reservation entity
     *
     */
    public function save(Reservation $reservation): void
    {
        $this->_em->persist($reservation);
        $this->_em->flush();
    }

    /**
     * delete entity.
     *
     * @param Reservation $reservation Reservation entity
     *
     */
    public function delete(Reservation $reservation): void
    {
        $this->_em->remove($reservation);
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
        return $queryBuilder ?? $this->createQueryBuilder('reservation');
    }
//    /**
//     * @return Reservation[] Returns an array of Reservation objects
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

//    public function findOneBySomeField($value): ?Reservation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
