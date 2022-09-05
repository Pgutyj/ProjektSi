<?php

/**
 * ReservationStatus Entity.
 */

namespace App\Entity;

use App\Repository\ReservationStatusRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * class ReservationStatus.
 */
#[ORM\Entity(repositoryClass: ReservationStatusRepository::class)]
#[ORM\Table(name: 'reservationStatus')]
#[UniqueEntity(fields: ['name'])]
class ReservationStatus
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
     * status info.
     *
     * @var string
     */
    #[ORM\Column(type: 'string', length: 10)]
    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 10)]
    private ?string $statusInfo;

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
     * Getter for StatusInfo.
     *
     * @return string $statusInfo statusInfo
     */
    public function getStatusInfo(): ?string
    {
        return $this->statusInfo;
    }

    /**
     * setter for StatusInfo.
     *
     * @param string $statusInfo status info
     *
     * @return string $statusInfo statusInfo
     */
    public function setStatusInfo(string $statusInfo): self
    {
        $this->statusInfo = $statusInfo;

        return $this;
    }
}
