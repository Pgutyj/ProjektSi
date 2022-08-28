<?php
/**
 * Category Entity.
 */
namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 *  class Category
 */
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'categories')]
#[UniqueEntity(fields: ['name'])]
class Category
{
    /**
     * Primary key.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * name.
     *
     * @var string
     */
    #[ORM\Column(type: 'string', length: 20)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 64)]
    private ?string $name;

    /**
     * slug.
     *
     * @var string
     */
    #[ORM\Column(type: 'string', length: 128, nullable: true)]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 64)]
    #[Gedmo\Slug(fields: ['name'])]
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
     * Getter for name.
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * setter for name.
     *
     * @param string $name name
     *
     * @return void
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }
    /**
     * Getter for slug.
     *
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }
    /**
     * setter for slug.
     *
     * @param string $slug slug
     *
     * @return void
     */
    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }
}
