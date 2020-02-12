<?php

namespace AppBundle\Security;

use AppBundle\Entity\Usuario;
use AppBundle\Repository\DependenciaRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class DependenciaVoter extends Voter
{

    const DEPENDENCIA_MOSTRAR_SECCION = 'DEPENDENCIA_MOSTRAR_SECCION';

    private $accessDecisionManager;
    private $dependenciaRepository;

    /**
     * DependenciaVoter constructor.
     */
    public function __construct(DependenciaRepository $dependenciaRepository, AccessDecisionManagerInterface $accessDecisionManager)
    {
        $this->accessDecisionManager = $accessDecisionManager;
        $this->dependenciaRepository = $dependenciaRepository;
    }


    /**
     * @inheritDoc
     */
    protected function supports($attribute, $subject)
    {
        if ($attribute === self::DEPENDENCIA_MOSTRAR_SECCION) {
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $usuario = $token->getUser();

        if (!$usuario instanceof Usuario) {
            return false;
        }

        if ($attribute === self::DEPENDENCIA_MOSTRAR_SECCION) {
            // mostrar el menú si se cumple alguna de estas condiciones:
            // 1. el usuario tiene el rol de ROLE_GESTOR_PRESTAMOS
            if ($this->accessDecisionManager->decide($token, ['ROLE_GESTOR_PRESTAMOS'])) {
                return true;
            }

            // 2. es responsable de, al menos, una dependencia
            if ($this->dependenciaRepository->countByUsuarioResponsable($usuario) > 0) {
                return true;
            }

            return false;
        }

        return false;
    }
}