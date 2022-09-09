<?php
/**
 * BookTag Entity.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\BookTagRepository;

/**
 * class BookTag.
 */
#[ORM\Entity(repositoryClass: BookTagRepository::class)]
#[ORM\Table(name: 'book_tags')]
class BookTag
{
    /**
     * Primary key.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;
    /**
     * Tag.
     *
     * @var Tag $tag
     */
    #[ORM\ManyToOne(targetEntity: Tag::class, fetch: 'EXTRA_LAZY')]
    #[Assert\Type(Tag::class)]
    #[Assert\NotBlank]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tag $tag;
    /**
     * Book entity.
     *
     * @var Book $book
     */
    #[ORM\ManyToOne(targetEntity: Book::class, fetch: 'EXTRA_LAZY')]
    #[Assert\Type(Book::class)]
    #[Assert\NotBlank]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $book;

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
     * Getter for Tag.
     *
     * @return Tag $tag Tag entity
     */
    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    /**
     * setter for Tag.
     *
     * @param Tag $tag Tag entity
     *
     * @return self Entity Tag
     */
    public function setTag(?Tag $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Getter for Book.
     *
     * @return Tag $tag Tag entity
     */
    public function getBook(): ?Book
    {
        return $this->book;
    }

    /**
     * setter for Book.
     *
     * @param Book $book Tag entity
     *
     * @return self Entity Book
     */
    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }
}
