<?php
/**
 * UserType service.
 */

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

/**
 * Class UserService.
 */
class UserService implements UserServiceInterface
{
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
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
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
}
