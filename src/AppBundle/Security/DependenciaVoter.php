<?php

namespace AppBundle\Security;

use AppBundle\Entity\Dependencia;
use AppBundle\Entity\Usuario;
use AppBundle\Repository\DependenciaRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class DependenciaVoter extends Voter
{

    const DEPENDENCIA_MOSTRAR_SECCION = 'DEPENDENCIA_MOSTRAR_SECCION';
    const DEPENDENCIA_ACCEDER = 'DEPENDENCIA_ACCEDER';
    const DEPENDENCIA_CREAR = 'DEPENDENCIA_CREAR';

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
        if (in_array($attribute, [
            self::DEPENDENCIA_MOSTRAR_SECCION,
            self::DEPENDENCIA_ACCEDER,
            self::DEPENDENCIA_CREAR
        ], true)) {
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

        switch ($attribute) {
            case self::DEPENDENCIA_MOSTRAR_SECCION:
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

            case self::DEPENDENCIA_CREAR:
                // solamente el rol de secretario
                return $this->accessDecisionManager->decide($token, ['ROLE_SECRETARIO']);
        }

        if ($attribute === self::DEPENDENCIA_ACCEDER) {

            // comprobar si $subject es una Dependencia
            if (!$subject instanceof Dependencia) {
                return false;
            }

            // se puede acceder a la dependencia $subject
            // si se cumple alguna de estas condiciones:
            // 1. el usuario tiene el rol de ROLE_GESTOR_PRESTAMOS
            if ($this->accessDecisionManager->decide($token, ['ROLE_GESTOR_PRESTAMOS'])) {
                return true;
            }

            // 2. es responsable de $subject
            if ($subject->getResponsables()->contains($usuario)) {
                return true;
            }

            return false;
        }

        return false;
    }
}