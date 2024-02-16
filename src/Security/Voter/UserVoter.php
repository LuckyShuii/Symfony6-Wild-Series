<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    public const USER = 'VOTER_USER';
    public const ADMIN = 'VOTER_ADMIN';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::USER, self::ADMIN]);
        // utile pour vérif si l'auteur d'un post est le bon par exemple : && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::USER:
                if (in_array('ROLE_USER', $user->getRoles())) {
                    return true;
                }
                break;
            case self::ADMIN:
                if (in_array('ROLE_ADMIN', $user->getRoles())) {
                    return true;
                }
                break;
        }

        return false;
    }
}
