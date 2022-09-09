<?php
/**
 * Reservation service interface.
 */

namespace App\Service;

use App\Entity\User;
use App\Entity\Reservation;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\ORM\NonUniqueResultException;

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
     * @param int $id reservation id
     *
     * @return Reservation|null Category entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?Reservation;

    /**
     * Get paginated list of all reservations belonging to a certain user.
     *
     * @param int  $page      Page number
     * @param User $requester user entity
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedReservations(int $page, User $requester): PaginationInterface;
}
