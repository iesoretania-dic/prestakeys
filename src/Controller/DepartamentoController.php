<?php

namespace App\Controller;

use App\Entity\Departamento;
use App\Repository\DepartamentoRepository;
use App\Repository\LlaveRepository;
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
    /**
     * @Route("/departamento/llaves/{id}", name="departamento_llaves")
     */
    public function llaves(
        LlaveRepository $llaveRepository,
        Departamento $departamento
    ): Response
    {
        $llaves = $llaveRepository->findByDepartamentoOrdenadas($departamento);
        return $this->render('departamento/llaves.html.twig', [
            'departamento' => $departamento,
            'llaves' => $llaves
        ]);
    }
}
