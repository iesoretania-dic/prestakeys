<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Llave;
use AppBundle\Form\Model\Prestamo;
use AppBundle\Form\Type\LlaveType;
use AppBundle\Form\Type\PrestamoType;
use AppBundle\Repository\LlaveRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TFox\MpdfPortBundle\Service\MpdfService;
use Twig\Environment;

/**
 * @Security("is_granted('ROLE_GESTOR_PRESTAMOS')")
 */
class LlaveController extends Controller
{
    /**
     * @Route("/llaves/{filtro}", name="llave_listar",
     *      requirements={"filtro": "0|1|2"})
     */
    public function indexAction(LlaveRepository $llaveRepository, $filtro = 0)
    {
        if ($filtro !== 0 && $this->isGranted('ROLE_SECRETARIO') === false) {
            throw $this->createAccessDeniedException();
        }

        switch ($filtro) {
            case 0:
                $llaves = $llaveRepository->findPrestadasOrdenadasPorCodigo();
                break;
            case 1:
                $llaves = $llaveRepository->findNoPrestadasOrdenadasPorCodigo();
                break;
            case 2:
                $llaves = $llaveRepository->findAllOrdenadasPorCodigo();
                break;
        }

        return $this->render('llave/listar.html.twig', [
            'llaves' => $llaves,
            'filtro' => $filtro
        ]);
    }
    /**
     * @Route("/llave/nueva", name="llave_nueva", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_SECRETARIO')")
     */
    public function nuevaAction(Request $request)
    {
        $nuevaLlave = new Llave();
        $em = $this->getDoctrine()->getManager();
        $em->persist($nuevaLlave);

        return $this->formAction($request, $nuevaLlave);
    }

    /**
     * @Route("/llave/{id}", name="llave_form",
     *     requirements={"id"="\d+"}, methods={"GET", "POST"})
     * @Security("is_granted('ROLE_SECRETARIO')")
     */
    public function formAction(Request $request, Llave $llave)
    {
        $form = $this->createForm(LlaveType::class, $llave, [
            'nuevo' => $llave->getId() === null
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', 'Cambios en la llave guardados con éxito');
                return $this->redirectToRoute('llave_listar');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al guardar los cambios');
            }
        }
        return $this->render('llave/form.html.twig', [
            'form' => $form->createView(),
            'llave' => $llave
        ]);
    }

    /**
     * @Route("/llave/eliminar/{id}", name="llave_eliminar", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_SECRETARIO')")
     */
    public function eliminarAction(Request $request, Llave $llave)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($llave);
                $em->flush();
                $this->addFlash('success', 'Llave eliminada con éxito');
                return $this->redirectToRoute('llave_listar');
            }
            catch (\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al eliminar la llave');
                return $this->redirectToRoute('llave_form', ['id' => $llave->getId()]);
            }
        }
        return $this->render('llave/eliminar.html.twig', [
            'llave' => $llave
        ]);
    }

    /**
     * @Route("/llave/devolver/{id}", name="llave_devolver", methods={"GET", "POST"})
     */
    public function devolverAction(Request $request, Llave $llave)
    {
        if ($request->getMethod() == 'POST') {
            try {
                $llave->setFechaPrestamo(null);
                $llave->setUsuario(null);
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Llave devuelta con éxito');
                return $this->redirectToRoute('llave_listar');
            }
            catch (\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido un error al devolver la llave');
                return $this->redirectToRoute('llave_listar');
            }
        }
        return $this->render('llave/devolver.html.twig', [
            'llave' => $llave
        ]);
    }


    /**
     * @Route("/llave/prestar", name="llave_prestar", methods={"GET", "POST"})
     */
    public function prestarAction(Request $request)
    {
        $prestamo = new Prestamo();
        $form = $this->createForm(PrestamoType::class, $prestamo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $prestamo->getLlave()->setUsuario($prestamo->getUsuario());
                $prestamo->getLlave()->setFechaPrestamo(new \DateTime());
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', 'Llave prestada con éxito');
                return $this->redirectToRoute('llave_listar');
            }
            catch(\Exception $e) {
                $this->addFlash('error', 'Ha ocurrido al prestar la llave');
            }
        }
        return $this->render('llave/prestar_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/llave/informe", name="llave_informe", methods={"GET"})
     */
    public function informeAction(Request $request, LlaveRepository $llaveRepository, Environment $twig)
    {
        $llaves = $llaveRepository->findPrestadasOrdenadasPorCodigo();
        $mpdfService = new MpdfService();
        $html = $twig->render('llave/prestadas_informe.html.twig', [
            'llaves' => $llaves
        ]);

        return $mpdfService->generatePdfResponse($html);
    }
}
