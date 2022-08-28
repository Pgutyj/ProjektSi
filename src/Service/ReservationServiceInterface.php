<?php
/**
 * Reservation service interface.
 */

namespace App\Service;

use App\Entity\Category;
use App\Entity\Reservation;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * Interface ReservationServiceInterface.
 */
interface ReservationServiceInterface
{
    /**
     * Save entity.
     *
     * @param Reservation $reservation Reservation entity
     */
    public function save(Reservation $reservation): void;

    /**
     * delete entity.
     *
     * @param Reservation $reservation Reservation entity
     */
    public function delete(Reservation $reservation): void;

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface;

    /**
     * Find by id.
     *
     * @param int $id Category id
     *
     * @return Category|null Category entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Reservation;
}
