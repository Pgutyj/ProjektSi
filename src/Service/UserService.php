<?php
/**
 * UserType service.
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
    private $security;
    /**
     * UserType repository.
     */
    private UserRepository $userRepository;

    /**
     * Constructor.
     *
     * @param UserRepository     $userRepository UserType repository
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
     * @param User $user Book entity
     */
    public function save(User $user): void
    {
        $this->userRepository->save($user);
    }

    /**
     * Delete entity.
     *
     * @param User $user Book entity
     */
    public function delete(User $user): void
    {
        $this->userRepository->delete($user);
    }

    public function getCurrentUser(): void
    {
        $user = $this->security->getUser();
    }

    public function getPaginatedList(int $page): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->userRepository->queryAll(),
            $page,
            UserRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
}
