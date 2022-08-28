<?php
/**
 * Userservice.
 */

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class UserService.
 */
class UserService implements UserServiceInterface
{
    /**
     * security
     */
    private $security;

    /**
     * User repository.
     */
    private UserRepository $userRepository;

    /**
     * Constructor.
     *
     * @param UserRepository     $userRepository UserType repository
     * @param Security           $security       Security
     * @param PaginatorInterface $paginator      Paginator
     */
    public function __construct(UserRepository $userRepository, Security $security, PaginatorInterface $paginator)
    {
        $this->userRepository = $userRepository;
        $this->security = $security;
        $this->paginator = $paginator;
    }

    /**
     * Save entity.
     *
     * @param User $user User entity
     */
    public function save(User $user): void
    {
        $this->userRepository->save($user);
    }

    /**
     * Delete entity.
     *
     * @param User $user User entity
     */
    public function delete(User $user): void
    {
        $this->userRepository->delete($user);
    }

    /**
     * getter for the currently logged in user
     */
    public function getCurrentUser(): void
    {
        $user = $this->security->getUser();
    }

    /**
     * Get paginated list.
     *
     * @param int $page Page number
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->userRepository->queryAll(),
            $page,
            UserRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
}
