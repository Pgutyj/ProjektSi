<?php
/**
 * Book Entity.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use App\Repository\BookRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class Book.
 */
#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ORM\Table(name: 'books')]
class Book
{
    /**
     * Primary key.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;
    /**
     * title.
     *
     * @var string
     */
    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 100)]
    private ?string $title;
    /**
     * description.
     *
     * @var string
     */
    #[ORM\Column(type: 'string', length: 3000)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    private $description;
    /**
     * bookCreationTime.
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $bookCreationTime;
    /**
     * price.
     */
    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    private ?int $price;

    /**
     * Category.
     *
     * @var Category
     */
    #[ORM\ManyToOne(targetEntity: Category::class, fetch: 'EXTRA_LAZY')]
    #[Assert\Type(Category::class)]
    #[Assert\NotBlank]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category;

    /**
     * Tags.
     *
     * @var ArrayCollection<int, Tag>
     */
    #[Assert\Valid]
    #[ORM\ManyToMany(targetEntity: Tag::class, fetch: 'EXTRA_LAZY', orphanRemoval: true)]
    #[ORM\JoinTable(name: 'books_tags')]
    private $tags;

    /**
     * Author.
     *
     * @var User
     */
    #[ORM\ManyToOne(targetEntity: User::class, fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: true)]
    #[Assert\Type(User::class)]
    private ?User $author;

    /**
     * Author Info.
     *
     * @var AuthorInfo
     */
    #[ORM\ManyToOne(targetEntity: AuthorInfo::class, fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Type(AuthorInfo::class)]
    #[Assert\NotBlank]
    private ?AuthorInfo $bookAuthor = null;

    /**
     * Publishing House Info .
     *
     * @var PublishingHouseInfo
     */
    #[ORM\ManyToOne(targetEntity: PublishingHouseInfo::class, fetch: 'EXTRA_LAZY')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Type(PublishingHouseInfo::class)]
    #[Assert\NotBlank]
    private ?PublishingHouseInfo $publishingHouseInfo;

    /**
     *constructor.
     */
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
     * @return string $title title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Setter for Title.
     *
     * @param string $title title
     *
     * @return self string
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Getter for Description.
     *
     * @return string description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Setter for Description.
     *
     * @param string $description description
     *
     * @return self description
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Getter for bookCreationTime.
     *
     * @return DateTimeImmutable
     */
    public function getBookCreationTime(): ?DateTimeImmutable
    {
        return $this->bookCreationTime;
    }

    /**
     * Setter for bookCreationTime.
     *
     * @param DateTimeImmutable $bookCreationTime book Creation Time
     *
     * @return DateTimeImmutable $bookCreationTime $bookCreationTime
     */
    public function setBookCreationTime(DateTimeImmutable $bookCreationTime): void
    {
        $this->bookCreationTime = $bookCreationTime;
    }

    /**
     * Getter for Price.
     *
     * @return int price
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * Setter for Price.
     *
     * @param int|null $price book price
     *
     * @return self price
     */
    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Getter for category.
     *
     * @return Category Category entity
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Getter for category.
     *
     * @param Category|null $category Category entity
     *
     * @return Category Category entity
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * getter for tags.
     *
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * function for adding tags.
     *
     * @param Tag $tag Tag entity
     */
    public function addTag(Tag $tag): void
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }
    }

    /**
     * function for removing tags.
     *
     * @param Tag $tag Tag entity
     */
    public function removeTag(Tag $tag): void
    {
        $this->tags->removeElement($tag);
    }

    /**
     * getter for Author.
     *
     * @return User User entity
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * setter for author.
     *
     * @param User $author User entity
     *
     * @return self User entity
     */
    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * getter for AuthorInfo.
     *
     * @return AuthorInfo AuthorInfo entity
     */
    public function getAuthorInfo(): ?AuthorInfo
    {
        return $this->bookAuthor;
    }

    /**
     * setter for AuthorInfo.
     *
     * @param AuthorInfo $bookAuthor AuthorInfo entity
     */
    public function setAuthorInfo(?AuthorInfo $bookAuthor): void
    {
        $this->bookAuthor = $bookAuthor;
    }

    /**
     * getter for PublishingHouseInfo.
     *
     * @return PublishingHouseInfo PublishingHouseInfo entity
     */
    public function getPublishingHouseInfo(): ?PublishingHouseInfo
    {
        return $this->publishingHouseInfo;
    }

    /**
     * setter for PublishingHouseInfo.
     *
     * @param PublishingHouseInfo $publishingHouseInfo PublishingHouseInfo entity
     *
     * @return self PublishingHouseInfo entity
     */
    public function setPublishingHouseInfo(?PublishingHouseInfo $publishingHouseInfo): self
    {
        $this->publishingHouseInfo = $publishingHouseInfo;

        return $this;
    }
}
