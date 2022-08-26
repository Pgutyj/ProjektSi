<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ORM\Table(name: 'reservations')]
#[UniqueEntity(fields: ['name'])]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'datetime')]
    private $reservation_time;

    #[ORM\Column(type: 'text', nullable: true)]
    private $comment;

    #[ORM\ManyToOne(targetEntity: ReservationStatus::class, fetch: 'EXTRA_LAZY')]
    #[Assert\Type(ReservationStatus::class)]
    #[Assert\NotBlank]
    #[ORM\JoinColumn(nullable: true)]
    private $reservation_status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getReservationTime(): ?\DateTimeInterface
    {
        return $this->reservation_time;
    }

    public function setReservationTime(\DateTimeInterface $reservation_time): self
    {
        $this->reservation_time = $reservation_time;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getReservationStatus(): ?ReservationStatus
    {
        return $this->reservation_status;
    }

    public function setReservationStatus(?ReservationStatus $reservation_status): self
    {
        $this->reservation_status = $reservation_status;

        return $this;
    }
}
