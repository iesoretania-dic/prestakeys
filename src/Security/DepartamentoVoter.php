<?php

namespace App\Security;

use App\Entity\Departamento;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class DepartamentoVoter extends Voter
{
    const CREAR_LLAVE = 'CREAR_LLAVE';

    /**
     * @inheritDoc
     */
    protected function supports($attribute, $subject)
    {
        if (!$subject instanceof Departamento) {
            return false;
        }

        if ($attribute === self::CREAR_LLAVE) {
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if (!$subject instanceof Departamento) {
            return false;
        }

        if ($attribute === self::CREAR_LLAVE
            && $subject->getJefatura() == $token->getUser()) {
            return true;
        }

        return false;
    }
}