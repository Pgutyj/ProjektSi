<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Book;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;

class BookVoter extends Voter
{
    /**
     * Edit permission.
     *
     * @const string
     */
    public const EDIT = 'EDIT';

    /**
     * View permission.
     *
     * @const string
     */
    public const VIEW = 'VIEW';

    /**
     * Delete permission.
     *
     * @const string
     */
    public const DELETE = 'DELETE';

    /**
     * Create permission.
     *
     * @const string
     */
    public const CREATE = 'CREATE';

    /**
     * Security helper.
     */
    private Security $security;

    /**
     * OrderVoter constructor.
     *
     * @param Security $security Security helper
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof Book;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($subject, $user);
            case self::VIEW:
                return $this->canView($subject, $user);
            case self::DELETE:
                return $this->canDelete($subject, $user);
            case self::CREATE:
                return $this->canCreate($subject, $user);
        }

        return false;
    }

    /**
     * Checks if user can edit book.
     *
     * @param Book $book Book entity
     * @param User $user User
     *
     * @return bool Result
     */
    private function canEdit(Book $book, User $user): bool
    {
        return $book->getAuthor() === $user;
    }

    private function canCreate(Book $book, User $user): bool
    {
        return $book->getAuthor() === $user;
    }

    /**
     * Checks if user can view book.
     *
     * @param Book $book Book entity
     * @param User $user User
     *
     * @return bool Result
     */
    private function canView(Book $book, User $user): bool
    {
        return $book->getAuthor() === $user;
    }

    /**
     * Checks if user can delete task.
     *
     * @param Task $task Task entity
     * @param User $user User
     *
     * @return bool Result
     */
    private function canDelete(Book $book, User $user): bool
    {
        return $book->getAuthor() === $user;
    }
}
