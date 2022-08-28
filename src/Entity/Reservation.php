<?php

/**
 * Reservation Entity.
 */
namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * class Reservation
 */
#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ORM\Table(name: 'reservations')]
#[UniqueEntity(fields: ['name'])]
class Reservation
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
     * email.
     *
     * @var string
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    /**
     * reservationTime.
     *
     * Datetime_immutable
     */
    #[ORM\Column(type: 'datetime_immutable')]
    private $reservationTime;

    /**
     * comment.
     *
     * @var string
     */
    #[ORM\Column(type: 'text', nullable: true)]
    private $comment;

    /**
     * Reservation Status.
     *
     * @var ReservationStatus
     */
    #[ORM\ManyToOne(targetEntity: ReservationStatus::class, fetch: 'EXTRA_LAZY')]
    #[Assert\Type(ReservationStatus::class)]
    #[Assert\NotBlank]
    #[ORM\JoinColumn(nullable: true)]
    private $reservationStatus;

    /**
     * Book
     *
     * @var Book
     */
    #[ORM\OneToOne(targetEntity: Book::class, cascade: ['persist', 'remove'])]
    #[Assert\Type(Book::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Book $book = null;

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
     * Getter for email.
     *
     * @return string $email email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * setter for email.
     *
     * @param string $email
     *
     * @return string $email email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    /**
     * Getter for ReservationTime
     *
     * @return DateTimeImmutable $reservationTime
     */
    public function getReservationTime(): ?\DateTimeImmutable
    {
        return $this->reservationTime;
    }

    /**
     * setter for ReservationTime
     *
     * @param DateTimeImmutable $reservationTime
     *
     * @return DateTimeImmutable reservationTime
     */
    public function setReservationTime(\DateTimeImmutable $reservationTime): self
    {
        $this->reservationTime = $reservationTime;

        return $this;
    }

    /**
     * Getter for comment.
     *
     * @return string $comment comment
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * setter for comment.
     *
     * @param string|null $comment
     *
     * @return string $comment comment
     */
    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Getter for ReservationStatus.
     *
     * @return entity reservationStatus ReservationStatus
     */
    public function getReservationStatus(): ?ReservationStatus
    {
        return $this->reservationStatus;
    }

    /**
     * setter for ReservationStatus.
     *
     * @param entity $reservationStatus ReservationStatus
     *
     * @return self Entity Reservation Status
     */
    public function setReservationStatus(?ReservationStatus $reservationStatus): self
    {
        $this->reservationStatus = $reservationStatus;

        return $this;
    }

    /**
     * Getter for ReservationStatus.
     *
     * @return entity Book Book
     */
    public function getBook(): ?Book
    {
        return $this->book;
    }

    /**
     * setter for ReservationStatus.
     *
     * @param Book|null $book
     *
     * @return entity Book
     */
    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }
}
