<?php
/**
 * Author Info Entity.
 */

namespace App\Entity;

use App\Repository\AuthorInfoRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * class AuthorInfo.
 */
#[ORM\Entity(repositoryClass: AuthorInfoRepository::class)]
#[ORM\Table(name: 'authorInfos')]
#[UniqueEntity(fields: ['name'])]
class AuthorInfo
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
     * name.
     *
     * @var string $name name
     */
    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 64)]
    private ?string $name;

    #[ORM\Column(type: 'string', length: 100, unique: true)]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 100)]
    #[Gedmo\Slug(fields: ['name'])]
    private ?string $slug;

    /**
     * Getter for Id.
     *
     * @return int Id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for name.
     *
     * @return string name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Setter for name.
     *
     * @param string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
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
