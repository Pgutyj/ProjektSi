<?php

/**
 * Book fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Book;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class BookFixtures.
 *
 * @psalm-suppress MissingConstructor
 */
class BookFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }
        $this->createMany(100, 'books', function (int $i) {
            $book = new Book();
            $book->setTitle($this->faker->sentence);
            $book->setDescription($this->faker->sentence(50));
            $book->setBookCreationTime(DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-100 days', '-1 days')));
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
            // $reservation=$this->getRandomReference('reservations');
            // $author= $reservation->getRequester();
            $book->setAuthor(null);
            $bookAuthor = $this->getRandomReference('authorInfos');
            $book->setAuthorInfo($bookAuthor);
            $publishingHouseInfo = $this->getRandomReference('publishingHouseInfos');
            $book->setPublishingHouseInfo($publishingHouseInfo);

            return $book;
        });

        $this->manager->flush();
    }

    /**
     * get dependencies.
     *
     * @psalm-suppress PossiblyNullReference
     *
     * @return array Array of dependencies
     */
    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            TagFixtures::class,
            UserFixtures::class,
            AuthorInfoFixtures::class,
            PublishingHouseInfoFixtures::class,
                ];
    }
}
