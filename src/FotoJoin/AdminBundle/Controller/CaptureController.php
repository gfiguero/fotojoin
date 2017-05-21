<?php

namespace FotoJoin\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FotoJoin\AdminBundle\Entity\Capture;
use FotoJoin\AdminBundle\Form\CaptureType;

/**
 * Capture controller.
 *
 */
class CaptureController extends Controller
{
    /**
     * Lists all Capture entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $captures = $em->getRepository('FotoJoinAdminBundle:Capture')->findBy(array(), array($sort => $direction));
        else $captures = $em->getRepository('FotoJoinAdminBundle:Capture')->findAll();
        $paginator = $this->get('knp_paginator');
        $captures = $paginator->paginate($captures, $request->query->getInt('page', 1), 10);

        return $this->render('capture/index.html.twig', array(
            'captures' => $captures,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new Capture entity.
     *
     */
    public function newAction(Request $request)
    {
        $capture = new Capture();
        $form = $this->createForm('FotoJoin\AdminBundle\Form\CaptureType', $capture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($capture);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'capture.created' );    

            return $this->redirectToRoute('capture_show', array('id' => $capture->getId()));
        }

        return $this->render('capture/new.html.twig', array(
            'capture' => $capture,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Capture entity.
     *
     */
    public function showAction(Capture $capture)
    {
        $deleteForm = $this->createDeleteForm($capture);

        return $this->render('capture/show.html.twig', array(
            'capture' => $capture,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Capture entity.
     *
     */
    public function editAction(Request $request, Capture $capture)
    {
        $deleteForm = $this->createDeleteForm($capture);
        $editForm = $this->createForm('FotoJoin\AdminBundle\Form\CaptureType', $capture);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($capture);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'capture.edited' );    

            return $this->redirectToRoute('capture_edit', array('id' => $capture->getId()));
        }

        return $this->render('capture/edit.html.twig', array(
            'capture' => $capture,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Capture entity.
     *
     */
    public function deleteAction(Request $request, Capture $capture)
    {
        $form = $this->createDeleteForm($capture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($capture);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'capture.deleted' );    
        }

        return $this->redirectToRoute('capture_index');
    }

    /**
     * Creates a form to delete a Capture entity.
     *
     * @param Capture $capture The Capture entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Capture $capture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('capture_delete', array('id' => $capture->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
