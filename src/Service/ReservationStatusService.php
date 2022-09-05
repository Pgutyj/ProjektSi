<?php
/**
 * Reservation Status service.
 */

namespace App\Service;

use App\Entity\ReservationStatus;
use App\Repository\ReservationStatusRepository;

/**
 * Class ReservationStatusService.
 */
class ReservationStatusService implements ReservationStatusServiceInterface
{
    /**
     * Constructor.
     *
     * @param ReservationStatusRepository $reservationStatusRepository Category Repository
     */
    public function __construct(ReservationStatusRepository $reservationStatusRepository)
    {
        $this->reservationStatusRepository = $reservationStatusRepository;
    }

    /**
     * Find by id.
     *
     * @param int $id Category id
     *
     * @return Category|null Category entity
     *
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?ReservationStatus
    {
        return $this->reservationStatusRepository->findOneById($id);
    }
}
