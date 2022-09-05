<?php
/**
 * PublishingHouseInfo Entity.
 */

namespace App\Entity;

use App\Repository\PublishingHouseInfoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 *  class PublishingHouseInfo.
 */
#[ORM\Entity(repositoryClass: PublishingHouseInfoRepository::class)]
#[ORM\Table(name: 'publishingHouseInfos')]
#[UniqueEntity(fields: ['name'])]
class PublishingHouseInfo
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
     * @var string
     */
    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 100)]
    private ?string $name;

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
     * @return string $name name
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
     * @return self string
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
