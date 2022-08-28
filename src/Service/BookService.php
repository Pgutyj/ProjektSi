<?php
/**
 * Book service.
 */

namespace App\Service;

use App\Entity\Book;
use App\Entity\User;
use App\Repository\BookRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class BookService.
 */
class BookService implements BookServiceInterface
{
    /**
     * Category service.
     */
    private CategoryServiceInterface $categoryService;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Tag service.
     */
    private TagServiceInterface $tagService;

    /**
     * Book repository.
     */
    private BookRepository $bookRepository;

    /**
     * Constructor.
     *
     * @param CategoryServiceInterface $categoryService Category Service
     *
     * @param PaginatorInterface       $paginator       paginator
     *
     * @param TagServiceInterface      $tagService      Tag service
     *
     * @param TagServiceInterface      $bookRepository  Book Repository
     */
    public function __construct(CategoryServiceInterface $categoryService, PaginatorInterface $paginator, TagServiceInterface $tagService, BookRepository $bookRepository)
    {
        $this->categoryService = $categoryService;
        $this->paginator = $paginator;
        $this->tagService = $tagService;
        $this->bookRepository = $bookRepository;
    }
    /**
     * Get paginated list.
     *
     * @param int   $page    Page number
     *
     * @param User  $author  entity user
     *
     * @param array $filters array of filters
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page, User $author, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->bookRepository->queryByAuthor($author, $filters),
            $page,
            BookRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Get paginated list of all books that are available.
     *
     * @param int   $page    Page number
     *
     * @param array $filters array of filters
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedAll(int $page, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->bookRepository->queryAll($filters),
            $page,
            BookRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Book $book Book entity
     */
    public function save(Book $book): void
    {
        $this->bookRepository->save($book);
    }

    /**
     * Delete entity.
     *
     * @param Book $book Book entity
     */
    public function delete(Book $book): void
    {
        $this->bookRepository->delete($book);
    }

    /**
     * reserve entity.
     *
     * @param Book $book Book entity
     */
    public function reserve(Book $book): void
    {
        $this->bookRepository->reserve($book);
    }


    /**
     * Prepare filters for the book list.
     *
     * @param array<string, int> $filters Raw filters from request
     *
     * @return array<string, object> Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (!empty($filters['category_id'])) {
            $category = $this->categoryService->findOneById($filters['category_id']);
            if (null !== $category) {
                $resultFilters['category'] = $category;
            }
        }

        if (!empty($filters['tag_id'])) {
            $tag = $this->tagService->findOneById($filters['tag_id']);
            if (null !== $tag) {
                $resultFilters['tag'] = $tag;
            }
        }

        return $resultFilters;
    }
}
