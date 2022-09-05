<?php
/**
 * AuthorInfo service.
 */

namespace App\Service;

use App\Entity\AuthorInfo;
use App\Repository\AuthorInfoRepository;
use App\Repository\BookRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class Author Info service.
 */
class AuthorInfoService implements AuthorInfoServiceInterface
{
    /**
     * Book repository.
     */
    private BookRepository $bookRepository;
    /**
     * Author Info repository.
     */
    private AuthorInfoRepository $authorInfoRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param AuthorInfoRepository $authorInfoRepository Author Info Repository
     * @param PaginatorInterface   $paginator            paginator
     * @param BookRepository       $bookRepository       Book Repository
     */
    public function __construct(AuthorInfoRepository $authorInfoRepository, PaginatorInterface $paginator, BookRepository $bookRepository)
    {
        $this->authorInfoRepository = $authorInfoRepository;
        $this->paginator = $paginator;
        $this->bookRepository = $bookRepository;
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
            $this->authorInfoRepository->queryAll(),
            $page,
            AuthorInfoRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param AuthorInfo $authorInfo AuthorInfo entity
     */
    public function save(AuthorInfo $authorInfo): void
    {
        $this->authorInfoRepository->save($authorInfo);
    }

    /**
     * delete entity.
     *
     * @param AuthorInfo $authorInfo Category entity
     */
    public function delete(AuthorInfo $authorInfo): void
    {
        $this->authorInfoRepository->delete($authorInfo);
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
    public function findOneById(int $id): ?AuthorInfo
    {
        return $this->authorInfoRepository->findOneById($id);
    }

    /**
     * can Be Deleted .
     *
     * checks if entity can be deleted
     *
     * @param AuthorInfo $bookAuthor AuthorInfo entity
     *
     * @return bool false if thrown exception
     */
    public function canBeDeleted(AuthorInfo $bookAuthor): bool
    {
        try {
            $result = $this->bookRepository->countByBookAuthor($bookAuthor);

            return !($result > 0);
        } catch (NoResultException|NonUniqueResultException) {
            return false;
        }
    }
}
