<?php
/**
 * AuthorInfo service interface.
 */

namespace App\Service;

use App\Entity\AuthorInfo;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Interface AuthorInfoServiceInterface.
 */
interface AuthorInfoServiceInterface
{
    /**
     * Save entity.
     *
     * @param AuthorInfo $authorInfo AuthorInfo entity
     */
    public function save(AuthorInfo $authorInfo): void;

    /**
     * delete entity.
     *
     * @param AuthorInfo $authorInfo AuthorInfo entity
     */
    public function delete(AuthorInfo $authorInfo): void;

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
     * @param AuthorInfo $authorInfo AuthorInfo entity
     */
    public function canBeDeleted(AuthorInfo $authorInfo): bool;

    /**
     * Find by id.
     *
     * @param int $id AuthorInfo id
     *
     * @return AuthorInfo|null AuthorInfo entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?AuthorInfo;
}
