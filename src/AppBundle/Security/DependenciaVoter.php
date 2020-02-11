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
    const DEPENDENCIA_ACCEDER = 'DEPENDENCIA_ACCEDER';
    const DEPENDENCIA_CAMBIAR_DATOS = 'DEPENDENCIA_CAMBIAR';
    const DEPENDENCIA_CAMBIAR_RESPONSABLES = 'DEPENDENCIA_CAMBIAR_RESPONSABLES';
    const DEPENDENCIA_MOSTRAR_SECCION = 'DEPENDENCIA_MOSTRAR_SECCION';
    const DEPENDENCIA_CREAR = 'DEPENDENCIA_CREAR';
    const DEPENDENCIA_ELIMINAR = 'DEPENDENCIA_ELIMINAR';

    private $accessDecisionManager;
    /**
     * @var DependenciaRepository
     */
    private $dependenciaRepository;

    /**
     * DependenciaVoter constructor.
     */
    public function __construct(AccessDecisionManagerInterface $accessDecisionManager,
                                DependenciaRepository $dependenciaRepository
    ) {
        $this->accessDecisionManager = $accessDecisionManager;
        $this->dependenciaRepository = $dependenciaRepository;
    }


    /**
     * @inheritDoc
     */
    protected function supports($attribute, $subject)
    {
        // comprobar si es alguno de los atributos que hemos cubierto
        if (in_array($attribute, [
                // sin necesidad de especificar dependencia
                self::DEPENDENCIA_MOSTRAR_SECCION,
                self::DEPENDENCIA_CREAR,
                // necesitan dependencia
                self::DEPENDENCIA_ACCEDER,
                self::DEPENDENCIA_CAMBIAR_DATOS,
                self::DEPENDENCIA_CAMBIAR_RESPONSABLES,
                self::DEPENDENCIA_ELIMINAR,
            ], true) === false) {
            return false;
        }

        // si es un atributo que no depende de $subject (la dependencia), permitir la comprobación
        if (in_array($attribute, [
                self::DEPENDENCIA_MOSTRAR_SECCION,
                self::DEPENDENCIA_CREAR
            ], true)) {
            return true;
        }

        // es necesario confirmar que $subject sea una entidad Dependencia
        if ($subject instanceof Dependencia) {
            return true;
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        // asegurar que el usuario actual es del tipo de la entidad que hemos definido (Usuario)
        $usuario = $token->getUser();
        if ($usuario instanceof Usuario === false) {
            return false;
        }

        // asegurar de que $subject es una dependencia (salvo para los atributos que no lo necesitan)
        if (in_array($attribute, [
                self::DEPENDENCIA_MOSTRAR_SECCION,
                self::DEPENDENCIA_CREAR
            ], true) === false && $subject instanceof Dependencia === false) {
            return false;
        }

        /**
         * @var Dependencia $subject
         */

        // si es el secretario, tener acceso siempre
        if ($this->accessDecisionManager->decide($token, ['ROLE_SECRETARIO'])) {
            return true;
        }

        switch ($attribute) {
            case self::DEPENDENCIA_ACCEDER:
                // devolver verdadero si entre los usuarios responsables de la dependencia está el usuario actual
                return $subject->getResponsables()->contains($usuario);
            case self::DEPENDENCIA_CAMBIAR_DATOS:
                // devolver verdadero si entre los usuarios responsables de la dependencia está el usuario actual y
                // es un gestor de préstamos
                return $subject->getResponsables()->contains($usuario)
                    && $this->accessDecisionManager->decide($token, ['ROLE_GESTOR_PRESTAMOS']);
            case self::DEPENDENCIA_MOSTRAR_SECCION:
                // devolver verdadero si el usuario actual es responsable de al menos una dependencia
                return $this->dependenciaRepository->countByUsuarioResponsable($usuario) > 0;
            case self::DEPENDENCIA_CREAR:
            case self::DEPENDENCIA_CAMBIAR_RESPONSABLES:
                // sólo permitir a los secretarios
                return $this->accessDecisionManager->decide($token, ['ROLE_SECRETARIO']);
            case self::DEPENDENCIA_ELIMINAR:
                // sólo permitir a los gestores de préstamos y si son el único responsable de la dependencia
                return $this->accessDecisionManager->decide($token, ['ROLE_GESTOR_PRESTAMOS'])
                    && $subject->getResponsables()->contains($usuario) && $subject->getResponsables()->count() === 1;
        }

        // denegar en cualquier otro caso (no debería ocurrir, pero por si las moscas)
        return false;
    }
}
