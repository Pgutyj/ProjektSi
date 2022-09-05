<?php
/**
 * Tag service.
 */

namespace App\Service;

use App\Entity\Tag;
use App\Repository\BookRepository;
use App\Repository\TagRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 *  class TagService.
 */
class TagService implements TagServiceInterface
{
    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param TagRepository      $tagRepository  Tag Repository
     * @param PaginatorInterface $paginator      paginator
     * @param BookRepository     $bookRepository Book Repository
     */
    public function __construct(TagRepository $tagRepository, PaginatorInterface $paginator, BookRepository $bookRepository)
    {
        $this->tagRepository = $tagRepository;
        $this->paginator = $paginator;
        $this->bookRepository = $bookRepository;
    }

    /**
     * Find by title.
     *
     * @param string $tagInfo Tag tag_info
     *
     * @return Tag|null Tag entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneByTagInfo(string $tagInfo): ?Tag
    {
        return $this->tagRepository->findOneByTagInfo($tagInfo);
    }

    /**
     * Save entity.
     *
     * @param Tag $tag Tag entity
     */
    public function save(Tag $tag): void
    {
        $this->tagRepository->save($tag);
    }

    /**
     * delete entity.
     *
     * @param Tag $tag Tag entity
     */
    public function delete(Tag $tag): void
    {
        $this->tagRepository->delete($tag);
    }

    /**
     * can Be Deleted .
     *
     * checks if entity can be deleted
     *
     * @param Tag $tag Tag entity
     *
     * @return bool false if exception is thrown
     */
    public function canBeDeleted(Tag $tag): bool
    {
        try {
            $result = $this->bookRepository->countByTag($tag);

            return !($result > 0);
        } catch (NoResultException|NonUniqueResultException) {
            return false;
        }
    }

    /**
     * Find by id.
     *
     * @param int $id Tag id
     *
     * @return Tag|null Tag entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Tag
    {
        return $this->tagRepository->findOneById($id);
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
            $this->tagRepository->queryAll(),
            $page,
            TagRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
}
