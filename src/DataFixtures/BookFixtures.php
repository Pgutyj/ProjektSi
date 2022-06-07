<?php

namespace App\DataFixtures;

use App\Entity\Book;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class BookFixtures extends AbstractBaseFixtures
{
    /**
     * Faker.
     *
     * @var Generator
     */
    protected Generator $faker;

    /**
     * Persistence object manager.
     *
     * @var ObjectManager
     */
    protected ObjectManager $manager;

    /**
     * Load.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    public function loadData(): void
    {
        $this->faker = Factory::create();

        for ($i = 0; $i < 100; ++$i) {
            $book = new Book();
            $book->setTitle($this->faker->sentence);
            $book->setDescription($this->faker->sentence);
            $book->setBookCreationTime( DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days')));
            $book->setPrice($this->faker->numberBetween(15, 50));
            $this->manager->persist($book);
        }

        $this->manager->flush();
    }


}
