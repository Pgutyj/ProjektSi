<?php

namespace App\DataFixtures;

use App\Entity\Book;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BookFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }
        $this->createMany(100, 'books', function (int $i) {
            $book = new Book();
            $book->setTitle($this->faker->sentence);
            $book->setDescription($this->faker->sentence(50));
            $book->setbook_creation_time(DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days')));
            $book->setPrice($this->faker->numberBetween(15, 50));
            $category = $this->getRandomReference('categories');
            $book->setCategory($category);
            $tags = $this->getRandomReferences(
                'tags',
                $this->faker->numberBetween(0, 5)
            );
            foreach ($tags as $tag) {
                $book->addTag($tag);
            }

            $author = $this->getRandomReference('users');
            $book->setAuthor($author);

            return $book;
        });

        $this->manager->flush();
    }

    public function getDependencies(): array
    {
        return [CategoryFixtures::class, TagFixtures::class, UserFixtures::class];
    }
}
