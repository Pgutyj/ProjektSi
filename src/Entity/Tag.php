<?php
/**
 * Tag Entity.
 */

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
/**
 * class Tag.
 */
#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ORM\Table(name: 'tags')]
class Tag
{
    /**
     * Primary key.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id;

    /**
     * Tag info.
     *
     * @var string
     */
    #[ORM\Column(type: 'string', length: 40)]
    private ?string $tagInfo;

    #[ORM\Column(type: 'string', length: 40, unique: true)]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 40)]
    #[Gedmo\Slug(fields: ['tagInfo'])]
    private ?string $slug;

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
     * Getter for Tag info.
     *
     * @return string $tagInfo tagInfo
     */
    public function getTagInfo(): ?string
    {
        return $this->tagInfo;
    }

    /**
     * setter for Tag info.
     *
     * @param string $tagInfo tag name/information
     *
     * @return string $tagInfo tagInfo
     */
    public function setTagInfo(string $tagInfo): self
    {
        $this->tagInfo = $tagInfo;

        return $this;
    }

    /**
     * function for adding books.
     *
     * @param Book $book Book entity
     *
     * @return self Book entity
     */
    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
            $book->addTag($this);
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }
}
