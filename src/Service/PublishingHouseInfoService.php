<?php
/**
 * APublishingHouseInfo service.
 */

namespace App\Service;

use App\Entity\PublishingHouseInfo;
use App\Repository\PublishingHouseInfoRepository;
use App\Repository\BookRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * Publishing House Info Service.
 */
class PublishingHouseInfoService implements PublishingHouseInfoServiceInterface
{
    /**
     * Book repository.
     */
    private BookRepository $bookRepository;
    /**
     * Publishing House Info Repository.
     */
    private PublishingHouseInfoRepository $publishingHouseInfoRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Save entity.
     *
     * @param PublishingHouseInfo $publishingHouseInfo PublishingHouseInfo entity
     */
    public function save(PublishingHouseInfo $publishingHouseInfo): void
    {
        $this->publishingHouseInfoRepository->save($publishingHouseInfo);
    }

    /**
     * delete entity.
     *
     * @param PublishingHouseInfo $publishingHouseInfo PublishingHouseInfo entity
     */
    public function delete(PublishingHouseInfo $publishingHouseInfo): void
    {
        $this->publishingHouseInfoRepository->delete($publishingHouseInfo);
    }

    /**
     * Constructor.
     *
     * @param PublishingHouseInfoRepository $publishingHouseInfoRepository PublishingHouseInfoRepository
     * @param PaginatorInterface            $paginator                     paginator
     * @param BookRepository                $bookRepository                Book Repository
     */
    public function __construct(PublishingHouseInfoRepository $publishingHouseInfoRepository, PaginatorInterface $paginator, BookRepository $bookRepository)
    {
        $this->publishingHouseInfoRepository = $publishingHouseInfoRepository;
        $this->paginator = $paginator;
        $this->bookRepository = $bookRepository;
    }

    /**
     * Find by id.
     *
     * @param int $id Category id
     *
     * @return PublishingHouseInfo|null Category entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?PublishingHouseInfo
    {
        return $this->publishingHouseInfoRepository->findOneById($id);
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
            $this->publishingHouseInfoRepository->queryAll(),
            $page,
            PublishingHouseInfoRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * can Be Deleted .
     *
     * checks if entity can be deleted
     *
     * @param PublishingHouseInfo $publishingHouseInfo PublishingHouseInfo entity
     *
     * @return bool false if thrown exception
     */
    public function canBeDeleted(PublishingHouseInfo $publishingHouseInfo): bool
    {
        try {
            $result = $this->bookRepository->countByPublishingHouseInfo($publishingHouseInfo);

            return !($result > 0);
        } catch (NoResultException|NonUniqueResultException) {
            return false;
        }
    }
}
