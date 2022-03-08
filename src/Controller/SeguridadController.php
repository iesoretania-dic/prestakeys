<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SeguridadController extends AbstractController
{
    /**
     * @Route("/entrar", name="seguridad_login")
     */
    public function entrar(AuthenticationUtils $authenticationUtils) : Response
    {
        return $this->render('seguridad/entrada.html.twig', [
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'ultimo_usuario' => $authenticationUtils->getLastUsername()
        ]);
    }

    /**
     * @Route("/salir", name="seguridad_logout")
     */
    public function salir() : Response
    {
        throw new AccessDeniedHttpException();
    }
}