<?php

namespace FotoJoin\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FotoJoin\AdminBundle\Entity\Datetime;
use FotoJoin\AdminBundle\Form\DatetimeType;

/**
 * Datetime controller.
 *
 */
class DatetimeController extends Controller
{
    /**
     * Lists all Datetime entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $datetimes = $em->getRepository('FotoJoinAdminBundle:Datetime')->findBy(array(), array($sort => $direction));
        else $datetimes = $em->getRepository('FotoJoinAdminBundle:Datetime')->findAll();
        $paginator = $this->get('knp_paginator');
        $datetimes = $paginator->paginate($datetimes, $request->query->getInt('page', 1), 10);

        return $this->render('datetime/index.html.twig', array(
            'datetimes' => $datetimes,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new Datetime entity.
     *
     */
    public function newAction(Request $request)
    {
        $datetime = new Datetime();
        $form = $this->createForm('FotoJoin\AdminBundle\Form\DatetimeType', $datetime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($datetime);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'datetime.created' );    

            return $this->redirectToRoute('datetime_show', array('id' => $datetime->getId()));
        }

        return $this->render('datetime/new.html.twig', array(
            'datetime' => $datetime,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Datetime entity.
     *
     */
    public function showAction(Datetime $datetime)
    {
        $deleteForm = $this->createDeleteForm($datetime);

        return $this->render('datetime/show.html.twig', array(
            'datetime' => $datetime,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Datetime entity.
     *
     */
    public function editAction(Request $request, Datetime $datetime)
    {
        $deleteForm = $this->createDeleteForm($datetime);
        $editForm = $this->createForm('FotoJoin\AdminBundle\Form\DatetimeType', $datetime);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($datetime);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'datetime.edited' );    

            return $this->redirectToRoute('datetime_edit', array('id' => $datetime->getId()));
        }

        return $this->render('datetime/edit.html.twig', array(
            'datetime' => $datetime,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Datetime entity.
     *
     */
    public function deleteAction(Request $request, Datetime $datetime)
    {
        $form = $this->createDeleteForm($datetime);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($datetime);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'datetime.deleted' );    
        }

        return $this->redirectToRoute('datetime_index');
    }

    /**
     * Creates a form to delete a Datetime entity.
     *
     * @param Datetime $datetime The Datetime entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Datetime $datetime)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('datetime_delete', array('id' => $datetime->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
