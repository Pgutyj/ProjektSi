<?php
/**
 * Book Entity
 */
namespace App\Entity;

use App\Entity\Category;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
//#[ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="tasks", fetch="EXTRA_LAZY")]
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

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category=null;

    #[Assert\Valid]
    #[ORM\ManyToMany(targetEntity: Tag::class, fetch: 'EXTRA_LAZY', orphanRemoval: true)]
    #[ORM\JoinTable(name: 'books_tags')]
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }
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
    public function getbook_creation_time(): ?\DateTimeInterface
    {
        return $this->book_creation_time;
    }
    /**
     * Setter for book_creation_time.
     *
     * @return DateTimeInterface|null $book_creation_time book_creation_time
     */
    public function setbook_creation_time(\DateTimeInterface $book_creation_time): self
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): void
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

    }

    public function removeTag(Tag $tag): void
    {
        $this->tags->removeElement($tag);

    }
}
