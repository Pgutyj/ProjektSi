<?php
/**
 * UserType service interface.
 */

namespace App\Service;

use App\Entity\User;

/**
 * Interface TaskServiceInterface.
 */
interface UserServiceInterface
{
    /**
     * save entity.
     *
     * @param User $user User entity
     */
    public function save(User $user): void;

    /**
     * Delete entity.
     *
     * @param User $user User entity
     */
    public function delete(User $user): void;
}
