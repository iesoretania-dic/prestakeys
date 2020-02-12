<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Dependencia;
use AppBundle\Form\Type\DependenciaType;
use AppBundle\Repository\DependenciaRepository;
use AppBundle\Repository\LlaveRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("is_granted('DEPENDENCIA_MOSTRAR_SECCION')")
 */
class DependenciaController extends Controller
{
    /**
     * @Route("/dependencias", name="dependencia_listar")
     */
    public function indexAction(DependenciaRepository $dependenciaRepository)
    {
        $dependencias = $dependenciaRepository->findAllOrdenadas();

        return $this->render('dependencia/listar.html.twig', [
            'dependencias' => $dependencias
        ]);
    }

    /**
     * @Route("/dependencia/llaves/{id}", name="dependencia_llaves_listar")
     * @Security("is_granted('DEPENDENCIA_ACCEDER', dependencia)")
     */
    public function llavesAction(LlaveRepository $llaveRepository, Dependencia $dependencia)
    {
        $llaves = $llaveRepository->findByDependencia($dependencia);

        return $this->render('dependencia/listar_llaves.html.twig', [
            'llaves' => $llaves,
            'dependencia' => $dependencia
        ]);
    }

    /**
     * @Route("/dependencia/nueva", name="dependencia_nueva",
     *      methods={"GET", "POST"})
     * @Security("is_granted('DEPENDENCIA_CREAR')")
     */
    public function nuevaAction(Request $request)
    {
        $nuevaDependencia = new Dependencia();
        $this->getDoctrine()->getManager()->persist($nuevaDependencia);

        return $this->formAction($request, $nuevaDependencia);
    }

    /**
     * @Route("/dependencia/{id}", name="dependencia_form",
     *      requirements={"id"="\d+"}, methods={"GET", "POST"})
     * @Security("is_granted('DEPENDENCIA_ACCEDER', dependencia)")
     */
    public function formAction(Request $request, Dependencia $dependencia)
    {
        $formulario = $this->createForm(DependenciaType::class, $dependencia, [
            'disabled' => $this->isGranted('DEPENDENCIA_MODIFICAR', $dependencia) === false,
            'modificar_responsables' => $this->isGranted('DEPENDENCIA_MODIFICAR_RESPONSABLES', $dependencia)
        ]);
        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', 'Cambios en la dependencia guardados con éxito');
                return $this->redirectToRoute('dependencia_listar');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al guardar los cambios');
            }
        }
        return $this->render('dependencia/form.html.twig', [
            'dependencia' => $dependencia,
            'formulario' => $formulario->createView()
        ]);
    }

    /**
     * @Route("/dependencia/eliminar/{id}", name="dependencia_eliminar", methods={"GET", "POST"})
     * @Security("is_granted('DEPENDENCIA_ELIMINAR', dependencia)")
     */
    public function eliminarAction(Request $request, Dependencia $dependencia)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($dependencia);
                $em->flush();
                $this->addFlash('success', 'Dependencia eliminada con éxito');
                return $this->redirectToRoute('dependencia_listar');
            }
            catch (\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al eliminar la dependencia');
                return $this->redirectToRoute('dependencia_form', ['id' => $dependencia->getId()]);
            }
        }
        return $this->render('dependencia/eliminar.html.twig', [
            'dependencia' => $dependencia
        ]);
    }
}
