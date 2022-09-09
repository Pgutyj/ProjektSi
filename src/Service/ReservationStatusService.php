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
     * Reservation Status Repository.
     */
    private ReservationStatusRepository $reservationStatusRepository;

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
     * @return ReservationStatus|null ReservationStatus entity
     */
    public function findOneById(int $id): ?ReservationStatus
    {
        return $this->reservationStatusRepository->findOneById($id);
    }
}
