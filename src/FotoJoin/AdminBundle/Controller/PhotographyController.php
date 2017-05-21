<?php

namespace FotoJoin\ControlPanelBundle\Controller;

use FotoJoin\ControlPanelBundle\Entity\Photography;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Photography controller.
 *
 */
class PhotographyController extends Controller
{
    /**
     * Lists all photography entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $photographies = $em->getRepository('FotoJoinControlPanelBundle:Photography')->findAll();

        return $this->render('photography/index.html.twig', array(
            'photographies' => $photographies,
        ));
    }

    /**
     * Creates a new photography entity.
     *
     */
    public function newAction(Request $request)
    {
        $photography = new Photography();
        $form = $this->createForm('FotoJoin\ControlPanelBundle\Form\PhotographyType', $photography);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($photography);
            $em->flush();

            return $this->redirectToRoute('admin_photography_show', array('id' => $photography->getId()));
        }

        return $this->render('photography/new.html.twig', array(
            'photography' => $photography,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a photography entity.
     *
     */
    public function showAction(Photography $photography)
    {
        $deleteForm = $this->createDeleteForm($photography);

        return $this->render('photography/show.html.twig', array(
            'photography' => $photography,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing photography entity.
     *
     */
    public function editAction(Request $request, Photography $photography)
    {
        $deleteForm = $this->createDeleteForm($photography);
        $editForm = $this->createForm('FotoJoin\ControlPanelBundle\Form\PhotographyType', $photography);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_photography_edit', array('id' => $photography->getId()));
        }

        return $this->render('photography/edit.html.twig', array(
            'photography' => $photography,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a photography entity.
     *
     */
    public function deleteAction(Request $request, Photography $photography)
    {
        $form = $this->createDeleteForm($photography);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($photography);
            $em->flush();
        }

        return $this->redirectToRoute('admin_photography_index');
    }

    /**
     * Creates a form to delete a photography entity.
     *
     * @param Photography $photography The photography entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Photography $photography)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_photography_delete', array('id' => $photography->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
