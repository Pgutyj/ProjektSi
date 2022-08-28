<?php
/**
 * Author Info fixtures.
 */

namespace App\DataFixtures;

use App\Entity\AuthorInfo;

/**
 * Class AuthorInfoFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class AuthorInfoFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        $this->createMany(20, 'authorInfos', function (int $i) {
            $authorInfo = new authorInfo();
            $authorInfo->setName($this->faker->unique()->word);

            return $authorInfo;
        });

        $this->manager->flush();
    }
}
