<?php

namespace App\Security;

use App\Entity\Departamento;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class DepartamentoVoter extends Voter
{
    const CREAR_LLAVE = 'CREAR_LLAVE';

    /**
     * @var AccessDecisionManagerInterface
     */
    private $accessDecisionManager;

    public function __construct(AccessDecisionManagerInterface $accessDecisionManager)
    {
        $this->accessDecisionManager = $accessDecisionManager;
    }


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

        if ($this->accessDecisionManager->decide($token, ['ROLE_SECRETARIO'])) {
            return true;
        }

        if ($attribute === self::CREAR_LLAVE
            && $subject->getJefatura() == $token->getUser()) {
            return true;
        }

        return false;
    }
}