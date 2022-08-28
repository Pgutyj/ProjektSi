<?php
/**
 * Book repository.
 */

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Book;
use App\Entity\User;
use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * class BookRepository
 */
class BookRepository extends ServiceEntityRepository
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
    public const PAGINATOR_ITEMS_PER_PAGE = 10;

    /**
     * Constructor.
     *
     * @param ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    /**
     * Count books by category.
     *
     * @param Category $category Category
     *
     * @return int Number of books in category
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countByCategory(Category $category): int
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->select($qb->expr()->countDistinct('book.id'))
            ->where('book.category = :category')
            ->setParameter(':category', $category)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Count books by tag.
     *
     * @param Tag $tag Tag entity
     *
     * @return int Number of books in tag
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countByTag(Tag $tag): int
    {
        $qb = $this->getOrCreateQueryBuilder();

        return $qb->select($qb->expr()->countDistinct('book.id'))
            ->where('book.tags = :tag')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Save entity.
     *
     * @param Book $book Book entity
     *
     */
    public function save(Book $book): void
    {
        $this->_em->persist($book);
        $this->_em->flush();
    }

    /**
     * Delete entity.
     *
     * @param Book $book Book entity
     */
    public function delete(Book $book): void
    {
        $this->_em->remove($book);
        $this->_em->flush();
    }

    /**
     * reserve function.
     *
     * @param Book $book Book entity
     */
    public function reserve(Book $book): void
    {
        $this->_em->persist($book);
        $this->_em->flush();
    }

    /**
     * Query books by author.
     *
     * @param User                  $user    User entity
     *
     * @param array<string, object> $filters Filters array
     *
     * @return QueryBuilder Query builder
     */
    public function queryByAuthor(UserInterface $user, array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->queryAll($filters);

        $queryBuilder->andWhere('book.author = :author')
            ->setParameter('author', $user);

        return $queryBuilder;
    }

    /**
     * Query all records.
     *
     * @param array<string, object> $filters Filters array
     *
     * @return QueryBuilder Query builder
     */
    public function queryAll(array $filters): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->select(
                'partial book.{id, title, description, bookCreationTime, price}',
                'partial category.{id, name}',
                'partial tags.{id, tagInfo}',
                'partial PublishingHouseInfo.{id, name}',
                'partial AuthorInfo.{id, name}'
            )
            ->join('book.category', 'category')
            ->join('book.publishingHouseInfo', 'PublishingHouseInfo')
            ->join('book.bookAuthor', 'AuthorInfo')
            ->leftJoin('book.tags', 'tags')
            ->orderBy('book.bookCreationTime', 'DESC');

        return $this->applyFiltersToList($queryBuilder, $filters);
    }

    /**
     * Apply filters to paginated list.
     *
     * @param QueryBuilder          $queryBuilder Query builder
     * @param array<string, object> $filters      Filters array
     *
     * @return QueryBuilder Query builder
     */
    private function applyFiltersToList(QueryBuilder $queryBuilder, array $filters = []): QueryBuilder
    {
        if (isset($filters['category']) && $filters['category'] instanceof Category) {
            $queryBuilder->andWhere('category = :category')
                ->setParameter('category', $filters['category']);
        }

        if (isset($filters['tag']) && $filters['tag'] instanceof Tag) {
            $queryBuilder->andWhere('tags IN (:tag)')
                ->setParameter('tag', $filters['tag']);
        }

        return $queryBuilder;
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
        return $queryBuilder ?? $this->createQueryBuilder('book');
    }
}
