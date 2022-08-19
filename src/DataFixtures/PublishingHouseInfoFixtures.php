<?php
/**
 * Publishing House Info fixtures.
 */

namespace App\DataFixtures;

use App\Entity\PublishingHouseInfo;

/**
 * Class Publishing House Info Fixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class PublishingHouseInfoFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(20, 'publishingHouseInfos', function (int $i) {
            $publishingHouseInfo = new publishingHouseInfo();
            $publishingHouseInfo->setName($this->faker->sentence(3));

            return $publishingHouseInfo;
        });

        $this->manager->flush();
    }
}
