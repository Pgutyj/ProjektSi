<?php
/**
 * Book service interface.
 */

namespace App\Service;

use App\Entity\Book;
use App\Entity\User;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface BookServiceInterface.
 */
interface BookServiceInterface
{
    /**
     * Get paginated list.
     *
     * @param int   $page    Page number
     * @param User  $author  book author
     * @param array $filters array of filters
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page, User $author, array $filters = []): PaginationInterface;

    /**
     * Get paginated All.
     *
     * @param int   $page    Page number
     * @param array $filters array of filters
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedAll(int $page, array $filters = []): PaginationInterface;

    /**
     * Save entity.
     *
     * @param Book $book Book entity
     */
    public function save(Book $book): void;

    /**
     * delete entity.
     *
     * @param Book $book Book entity
     */
    public function delete(Book $book): void;

    /**
     * find a book by id.
     *
     * @param int $id book id
     *
     * @return Book book entity
     */
    public function findOneById(int $id): ?Book;
}
