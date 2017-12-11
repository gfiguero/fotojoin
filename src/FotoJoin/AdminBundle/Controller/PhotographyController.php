<?php

namespace FotoJoin\AdminBundle\Controller;

use FotoJoin\ControlPanelBundle\Entity\Photography;
use FotoJoin\AdminBundle\Form\PhotographyType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Photography controller.
 *
 */
class PhotographyController extends Controller
{

    /**
     * Lists all Photography entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $photographies = $em->getRepository('FotoJoinControlPanelBundle:Photography')->findBy(array(), array($sort => $direction));
        else $photographies = $em->getRepository('FotoJoinControlPanelBundle:Photography')->findAll();
        $paginator = $this->get('knp_paginator');
        $photographies = $paginator->paginate($photographies, $request->query->getInt('page', 1), 100);

        return $this->render('FotoJoinAdminBundle:Photography:index.html.twig', array(
            'photographies' => $photographies,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new Photography entity.
     *
     */
    public function newAction(Request $request)
    {
        $photography = new Photography();
        $newForm = $this->createNewForm($photography);
        $newForm->handleRequest($request);

        if ($newForm->isSubmitted()) {
            if($newForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($photography);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'success', 'photography.new.flash' );
                return $this->redirect($this->generateUrl('admin_photography_index'));
            }
        }

        return $this->render('FotoJoinAdminBundle:Photography:new.html.twig', array(
            'newForm' => $newForm->createView(),
        ));
    }

    /**
     * Creates a form to create a new Photography entity.
     *
     * @param Photography $photography The Photography entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createNewForm(Photography $photography)
    {
        return $this->createForm(new PhotographyType(), $photography, array(
            'action' => $this->generateUrl('admin_photography_new'),
        ));
    }

    /**
     * Finds and displays a Photography entity.
     *
     */
    public function showAction(Photography $photography)
    {
        $editForm = $this->createEditForm($photography);
        $deleteForm = $this->createDeleteForm($photography);

        return $this->render('FotoJoinAdminBundle:Photography:show.html.twig', array(
            'photography' => $photography,
            'editForm' => $editForm->createView(),
            'deleteForm' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Photography entity.
     *
     */
    public function editAction(Request $request, Photography $photography)
    {
        $editForm = $this->createEditForm($photography);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted()) {
            if($editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($photography);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'success', 'photography.edit.flash' );
                return $this->redirect($this->generateUrl('admin_photography_index'));
            }
        }

        return $this->render('FotoJoinAdminBundle:Photography:edit.html.twig', array(
            'photography' => $photography,
            'editForm' => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Photography entity.
     *
     * @param Photography $photography The Photography entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Photography $photography)
    {
        return $this->createForm(new PhotographyType(), $photography, array(
            'action' => $this->generateUrl('admin_photography_edit', array('id' => $photography->getId())),
        ));
    }

    /**
     * Deletes a Photography entity.
     *
     */
    public function deleteAction(Request $request, Photography $photography)
    {
        $deleteForm = $this->createDeleteForm($photography);
        $deleteForm->handleRequest($request);

        if ($deleteForm->isSubmitted()) {
            if($deleteForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($photography);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'danger', 'photography.delete.flash' );
                return $this->redirect($this->generateUrl('admin_photography_index'));
            }
        }

        return $this->render('FotoJoinAdminBundle:Photography:delete.html.twig', array(
            'photography' => $photography,
            'deleteForm' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a Photography entity.
     *
     * @param Photography $photography The Photography entity
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
