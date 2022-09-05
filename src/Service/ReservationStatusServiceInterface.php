<?php
/**
 * Reservation Status Service interface.
 */

namespace App\Service;

use App\Entity\ReservationStatus;

/**
 * Interface CategoryServiceInterface.
 */
interface ReservationStatusServiceInterface
{
    /**
     * Find by id.
     *
     * @param int $id Category id
     *
     * @return ReservationStatus|null Category entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?ReservationStatus;
}
