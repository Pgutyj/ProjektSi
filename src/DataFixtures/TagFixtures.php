<?php

namespace App\DataFixtures;

use App\Entity\Tag;

class TagFixtures extends AbstractBaseFixtures
{
    public function loadData(): void
    {
        $this->createMany(20, 'tags', function (int $i) {
            $tag = new tag();
            $tag->setTag_info($this->faker->unique()->word);

            return $tag;
        });

        $this->manager->flush();
    }
}
