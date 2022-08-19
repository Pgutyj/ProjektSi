<?php
/**
 * ReservationStatus fixtures.
 */

namespace App\DataFixtures;

use App\Entity\ReservationStatus;

/**
 * Class ReservationStatusFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class ReservationStatusFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(3, 'reservationStatuses', function (int $i) {
            $reservationStatus = new reservationStatus();
            $reservationStatus->setStatusInfo('rejected');
            $reservationStatus->setStatusInfo('approved');
            $reservationStatus->setStatusInfo('refunded');

            return $reservationStatus;
        });

        $this->manager->flush();
    }
}
