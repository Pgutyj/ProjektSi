<?php
/**
 * Category service.
 */

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\BookRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class Category Service.
 */
class CategoryService implements CategoryServiceInterface
{
    /**
     * Book repository.
     */
    private BookRepository $bookRepository;
    /**
     * Category repository.
     */
    private CategoryRepository $categoryRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Save entity.
     *
     * @param Category $category Category entity
     */
    public function save(Category $category): void
    {
        $this->categoryRepository->save($category);
    }

    /**
     * delete entity.
     *
     * @param Category $category Category entity
     */
    public function delete(Category $category): void
    {
        $this->categoryRepository->delete($category);
    }

    /**
     * Constructor.
     *
     * @param CategoryRepository $categoryRepository Category Repository
     * @param PaginatorInterface $paginator          paginator
     * @param BookRepository     $bookRepository     Book Repository
     */
    public function __construct(CategoryRepository $categoryRepository, PaginatorInterface $paginator, BookRepository $bookRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->paginator = $paginator;
        $this->bookRepository = $bookRepository;
    }

    /**
     * Find by id.
     *
     * @param int $id Category id
     *
     * @return Category|null Category entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Category
    {
        return $this->categoryRepository->findOneById($id);
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->categoryRepository->queryAll(),
            $page,
            CategoryRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * can Be Deleted .
     *
     * checks if entity can be deleted
     *
     * @param Category $category Category entity
     *
     * @return bool false if thrown exception
     */
    public function canBeDeleted(Category $category): bool
    {
        try {
            $result = $this->bookRepository->countByCategory($category);

            return !($result > 0);
        } catch (NoResultException|NonUniqueResultException) {
            return false;
        }
    }
}
