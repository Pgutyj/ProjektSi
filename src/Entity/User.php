<?php
/**
 * User Entity.
 */

namespace App\Entity;

use App\Entity\Enum\UserRole;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * class User.
 */
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
#[ORM\UniqueConstraint(name: 'email_idx', columns: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * Primary key.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /**
     * email.
     *
     * @var string
     */
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email;

    /**
     * nick.
     *
     * @var string
     */
    #[ORM\Column(type: 'string', length: 20, unique: true)]
    #[Assert\NotBlank]
    private ?string $nick;

    /**
     * array for user roles.
     *
     * @var array<int, string>
     */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * password.
     *
     * @var string
     */
    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private ?string $password;

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
     * @param string $email email
     *
     * @return string $email email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * A visual identifier that represents this user.
     *
     * getter for user identifier - user email
     *
     * @return string user email
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     *
     * @return string nick
     */
    public function getUsername(): string
    {
        return (string) $this->nick;
    }

    /**
     * @see UserInterface
     * getter for User roles
     *
     * @return array<int, string> Roles
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = UserRole::ROLE_USER->value;

        return array_unique($roles);
    }

    /**
     * setter for roles.
     *
     * @param array<int, string> $roles Roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * getter for nick.
     *
     * @return string $nick nick
     */
    public function getNick(): ?string
    {
        return $this->nick;
    }

    /**
     * setter for nick.
     *
     * @param string $nick user nick
     */
    public function setNick(string $nick): void
    {
        $this->nick = $nick;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     *
     * getter for user password
     *
     * @return string password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     *@see PasswordAuthenticatedUserInterface
     *
     * setter for user password
     *
     * @param string $password user password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     *
     * @return string
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
