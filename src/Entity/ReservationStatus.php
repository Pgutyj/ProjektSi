<?php

namespace App\Entity;

use App\Repository\ReservationStatusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationStatusRepository::class)]
#[ORM\Table(name: 'reseravtionStatus')]
#[UniqueEntity(fields: ['name'])]
class ReservationStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 10)]
    private $status_info;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatusInfo(): ?string
    {
        return $this->status_info;
    }

    public function setStatusInfo(string $status_info): self
    {
        $this->status_info = $status_info;

        return $this;
    }
}
