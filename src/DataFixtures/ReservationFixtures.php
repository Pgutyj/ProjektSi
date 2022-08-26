<?php
/**
 * Reservation fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Reservation;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class ReservationFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class ReservationFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(20, 'reservations', function (int $i) {
            $reservation = new reservation();
            $reservation->setEmail(sprintf('user%d@example.com', $i));
            $reservation->setReservationTime(DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days')));
            $reservation->setComment($this->faker->sentence(50));
            $reservationStatus = $this->getRandomReference('reservationStatus');
            $reservation->setReservationStatus($reservationStatus);

            return $reservation;
        });

        $this->manager->flush();
    }

    public function getDependencies(): array
    {
        return [ReservationStatusFixtures::class];
    }
}
