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
        $this->createMany(4, 'reservationStatus', function (int $i) {
            $reservationStatus = new reservationStatus();
            if (0 === $i) {
                $reservationStatus->setStatusInfo('waiting');
            }
            if (1 === $i) {
                $reservationStatus->setStatusInfo('rejected');
            }
            if (2 === $i) {
                $reservationStatus->setStatusInfo('approved');
            }
            if (3 === $i) {
                $reservationStatus->setStatusInfo('refunded');
            }

            return $reservationStatus;
        });

        $this->manager->flush();
    }
}
