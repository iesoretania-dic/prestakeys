<?php

namespace App\Controller;

use App\Entity\Llave;
use App\Form\LlaveType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LlaveController extends AbstractController
{
    /**
     * @Route("/llave/{id}", name="llave_form")
     * @Security("is_granted('ROLE_EMPLEADO')")
     */
    public function index(Request $request, Llave $llave): Response
    {
        $form = $this->createForm(LlaveType::class, $llave);
        $form->handleRequest($request);

        return $this->render('llave/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
