<?php
/**
 * Book Entity
 */
namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ORM\Table(name: 'books')]
class Book
{
    /**
     * Primary key.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    /**
     * title.
     *
     * @var string|null
     *
     */
    #[ORM\Column(type: 'string', length: 100)]
    private $title;
    /**
     * description.
     *
     * @var text|null
     *
     */
    #[ORM\Column(type: 'text')]
    private $description;
    /**
     * book_creation_time.
     *
     * @var DateTimeImmutable|null
     *
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $book_creation_time;
    /**
     * price.
     *
     * @var int|null
     */
    #[ORM\Column(type: 'integer', nullable: true)]
    private $price;
    /**
     * Getter for Id.
     *
     * @return int|null Id
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * Getter for Title.
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }
    /**
     * Setter for Title.
     *
     * @return string|null $title title
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
    /**
     * Getter for Description.
     *
     * @return string|null description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
    /**
     * Setter for Description.
     *
     * @return string|null $description description
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
    /**
     * Getter for book_creation_time.
     *
     * @return DateTimeInterface|null book_creation_time
     */
    public function getBookCreationTime(): ?\DateTimeInterface
    {
        return $this->book_creation_time;
    }
    /**
     * Setter for book_creation_time.
     *
     * @return DateTimeInterface|null $book_creation_time book_creation_time
     */
    public function setBookCreationTime(\DateTimeInterface $book_creation_time): self
    {
        $this->book_creation_time = $book_creation_time;

        return $this;
    }
    /**
     * Getter for Price.
     *
     * @return int|null price
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }
    /**
     * Setter for Price.
     *
     * @return int|null $price price
     */
    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
