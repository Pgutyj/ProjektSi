<?php
/**
 * AuthorInfo service interface.
 */

namespace App\Service;

use App\Entity\PublishingHouseInfo;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Interface AuthorInfoServiceInterface.
 */
interface PublishingHouseInfoServiceInterface
{
    /**
     * Save entity.
     *
     * @param PublishingHouseInfo $publishingHouseInfo PublishingHouseInfo entity
     */
    public function save(PublishingHouseInfo $publishingHouseInfo): void;

    /**
     * delete entity.
     *
     * @param PublishingHouseInfo $publishingHouseInfo PublishingHouseInfo entity
     */
    public function delete(PublishingHouseInfo $publishingHouseInfo): void;

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;

    /**
     * can Be Deleted .
     *
     * checks if entity can be deleted
     *
     * @param PublishingHouseInfo $publishingHouseInfo PublishingHouseInfo entity
     */
    public function canBeDeleted(PublishingHouseInfo $publishingHouseInfo): bool;

    /**
     * Find by id.
     *
     * @param int $id PublishingHouseInfo id
     *
     * @return PublishingHouseInfo|null PublishingHouseInfo entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?PublishingHouseInfo;
}
