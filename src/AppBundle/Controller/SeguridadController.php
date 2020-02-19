<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SeguridadController extends Controller
{
    /**
     * @Route("/{_locale}/entrar", name="usuario_entrar")
     */
    public function indexAction(AuthenticationUtils $authUtils)
    {
        // obtener el error de autenticación, si hay alguno
        $error = $authUtils->getLastAuthenticationError();

        $ultimoUsuario = $authUtils->getLastUsername();

        // formulario de entrada
        return $this->render('seguridad/entrar.html.twig', [
            'error' => $error,
            'ultimo_usuario' => $ultimoUsuario
        ]);
    }

    /**
     * @Route("/salir", name="usuario_salir")
     */
    public function salirAction()
    {

    }
}
