<?php
/**
 * Author Info Repository.
 */
namespace App\Repository;

use App\Entity\AuthorInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * class AuthorInfoRepository
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
     * construct function.
     *
     * @param ManagerRegistry $registry Manager Registry
     *
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuthorInfo::class);
    }

    /**
     * Add entity.
     *
     * @param AuthorInfo $entity AuthorInfo entity
     *
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
     *
     * @param bool       $flush  flush
     */
    public function remove(AuthorInfo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
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
