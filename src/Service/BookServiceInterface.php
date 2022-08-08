<?php
/**
 * Book service interface.
 */

namespace App\Service;

use App\Entity\Book;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface TaskServiceInterface.
 */
interface BookServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;


    public function save(Book $book): void;



    public function delete(Book $book): void;

}