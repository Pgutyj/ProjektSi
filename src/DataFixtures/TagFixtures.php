<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TagFixtures extends AbstractBaseFixtures{
    public function loadData(): void
    {
        $this->createMany(20, 'tags', function (int $i) {
            $tag = new tag();
            $tag->setTagInfo($this->faker->unique()->word);
            return $tag;
        });

        $this->manager->flush();
    }
}