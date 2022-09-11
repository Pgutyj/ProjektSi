<?php
/**
 * Reservation Voter.
 */

namespace App\Security\Voter;

use App\Entity\Reservation;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;

/**
 * class ReservationVoter.
 */
class ReservationVoter extends Voter
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
     * Security helper.
     */
    private Security $security;

    /**
     * ReservationVoter constructor.
     *
     * @param Security $security Security helper
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed  $subject   The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool Result
     */
    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW, self::DELETE])
            && $subject instanceof Reservation;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string         $attribute Permission name
     * @param mixed          $subject   Object
     * @param TokenInterface $token     Security token
     *
     * @return bool Vote result
     */
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
        }

        return false;
    }

    /**
     * Checks if user can edit reservation.
     *
     * @param Reservation $reservation Reservation entity
     * @param User        $user        User
     *
     * @return bool Result
     */
    private function canEdit(Reservation $reservation, User $user): bool
    {
        return $reservation->getRequester() === $user || $user->getRoles() === ['ROLE_USER', 'ROLE_ADMIN'];
    }

    /**
     * Checks if user can view reservation.
     *
     * @param Reservation $reservation Reservation entity
     * @param User        $user        User
     *
     * @return bool Result
     */
    private function canView(Reservation $reservation, User $user): bool
    {
        return $reservation->getRequester() === $user || $user->getRoles() === ['ROLE_USER', 'ROLE_ADMIN'];
    }

    /**
     * Checks if user can delete reservation.
     *
     * @param Reservation $reservation Reservation entity
     * @param User        $user        User
     *
     * @return bool Result
     */
    private function canDelete(Reservation $reservation, User $user): bool
    {
        return $reservation->getRequester() === $user || $user->getRoles() === ['ROLE_USER', 'ROLE_ADMIN'];
    }
}
