<?php
/**
 * Tag Entity.
 */

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * class Tag
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
    private $id;

    /**
     * Tag info.
     *
     * @var string
     */
    #[ORM\Column(type: 'string', length: 40)]
    private $tagInfo;

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
     * function for adding books
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
}
