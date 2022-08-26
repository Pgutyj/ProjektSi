<?php
/**
 * Book service interface.
 */

namespace App\Service;

use App\Entity\Category;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface BookServiceInterface.
 */
interface CategoryServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function save(Category $category): void;

    public function delete(Category $category): void;

    public function getPaginatedList(int $page): PaginationInterface;

    public function canBeDeleted(Category $category): bool;

    public function findOneById(int $id): ?Category;
}
