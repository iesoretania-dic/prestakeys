<?php

namespace App\Controller;

use App\Repository\DepartamentoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepartamentoController extends AbstractController
{
    /**
     * @Route("/departamento", name="departamento_listar")
     */
    public function index(DepartamentoRepository $departamentoRepository): Response
    {
        $departamentos = $departamentoRepository->findAllOrdenados();
        return $this->render('departamento/index.html.twig', [
            'departamentos' => $departamentos
        ]);
    }
}
