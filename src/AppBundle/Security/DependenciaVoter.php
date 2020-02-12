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
    const DEPENDENCIA_ELIMINAR = 'DEPENDENCIA_ELIMINAR';
    const DEPENDENCIA_MODIFICAR = 'DEPENDENCIA_MODIFICAR';
    const DEPENDENCIA_MODIFICAR_RESPONSABLES = 'DEPENDENCIA_MODIFICAR_RESPONSABLES';

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
            self::DEPENDENCIA_CREAR,
            self::DEPENDENCIA_ELIMINAR,
            self::DEPENDENCIA_MODIFICAR,
            self::DEPENDENCIA_MODIFICAR_RESPONSABLES
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

        // Atributos que NO dependen de $subject
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

        // Atributos que SÍ dependen de $subject

        // comprobar si $subject es una Dependencia
        if (!$subject instanceof Dependencia) {
            return false;
        }

        switch ($attribute) {
            case self::DEPENDENCIA_ACCEDER:
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

            case self::DEPENDENCIA_ELIMINAR:
                // se puede eliminar la dependencia $subject
                // si se cumple alguna de estas condiciones:
                // 1. el usuario tiene el rol de Secretario
                if ($this->accessDecisionManager->decide($token, ['ROLE_SECRETARIO'])) {
                    return true;
                }

                // 2. es "gestor de préstamos" Y es el único responsable
                if ($this->accessDecisionManager->decide($token, ['ROLE_GESTOR_PRESTAMOS'])
                    && $subject->getResponsables()->contains($usuario)
                    && $subject->getResponsables()->count() === 1) {
                    return true;
                }

                return false;

            case self::DEPENDENCIA_MODIFICAR:
                // se puede modificar la dependencia $subject (salvo los responsables)
                // 1. Un usuario con rol de secretario
                if ($this->accessDecisionManager->decide($token, ['ROLE_SECRETARIO'])) {
                    return true;
                }

                // 2. Usuario con rol de gestor de préstamos y es que sea responsable
                // de la dependencia
                if ($this->accessDecisionManager->decide($token, ['ROLE_GESTOR_PRESTAMOS'])
                    && $subject->getResponsables()->contains($usuario)) {
                    return true;
                }
                return false;

            case self::DEPENDENCIA_MODIFICAR_RESPONSABLES:
                return $this->accessDecisionManager->decide($token, ['ROLE_SECRETARIO']);
        }

        return false;
    }
}