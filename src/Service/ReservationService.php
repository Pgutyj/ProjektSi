<?php
/**
 * Reservation service.
 */

namespace App\Service;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class ReservationService
 */
class ReservationService implements ReservationServiceInterface
{
    /**
     * Reservation Repository.
     */
    private ReservationRepository $reservationRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Save entity.
     *
     * @param Reservation $reservation Reservation entity
     */
    public function save(Reservation $reservation): void
    {
        $this->reservationRepository->save($reservation);
    }

    /**
     * delete entity.
     *
     * @param Reservation $reservation Reservation entity
     */
    public function delete(Reservation $reservation): void
    {
        $this->reservationRepository->delete($reservation);
    }

    /**
     * Constructor.
     *
     * @param ReservationRepository $reservationRepository Reservation Repository
     *
     * @param PaginatorInterface    $paginator             paginator
     */
    public function __construct(ReservationRepository $reservationRepository, PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
        $this->reservationRepository = $reservationRepository;
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
    public function findOneById(int $id): ?Reservation
    {
        return $this->reservationRepository->findOneById($id);
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->reservationRepository->queryAll(),
            $page,
            ReservationRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
}
