<?php

namespace FotoJoin\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FotoJoin\AdminBundle\Entity\Appraisement;
use FotoJoin\AdminBundle\Form\AppraisementType;

/**
 * Appraisement controller.
 *
 */
class AppraisementController extends Controller
{
    /**
     * Lists all Appraisement entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $appraisements = $em->getRepository('FotoJoinAdminBundle:Appraisement')->findBy(array(), array($sort => $direction));
        else $appraisements = $em->getRepository('FotoJoinAdminBundle:Appraisement')->findAll();
        $paginator = $this->get('knp_paginator');
        $appraisements = $paginator->paginate($appraisements, $request->query->getInt('page', 1), 10);

        return $this->render('appraisement/index.html.twig', array(
            'appraisements' => $appraisements,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new Appraisement entity.
     *
     */
    public function newAction(Request $request)
    {
        $appraisement = new Appraisement();
        $form = $this->createForm('FotoJoin\AdminBundle\Form\AppraisementType', $appraisement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($appraisement);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'appraisement.created' );    

            return $this->redirectToRoute('appraisement_show', array('id' => $appraisement->getId()));
        }

        return $this->render('appraisement/new.html.twig', array(
            'appraisement' => $appraisement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Appraisement entity.
     *
     */
    public function showAction(Appraisement $appraisement)
    {
        $deleteForm = $this->createDeleteForm($appraisement);

        return $this->render('appraisement/show.html.twig', array(
            'appraisement' => $appraisement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Appraisement entity.
     *
     */
    public function editAction(Request $request, Appraisement $appraisement)
    {
        $deleteForm = $this->createDeleteForm($appraisement);
        $editForm = $this->createForm('FotoJoin\AdminBundle\Form\AppraisementType', $appraisement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($appraisement);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'appraisement.edited' );    

            return $this->redirectToRoute('appraisement_edit', array('id' => $appraisement->getId()));
        }

        return $this->render('appraisement/edit.html.twig', array(
            'appraisement' => $appraisement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Appraisement entity.
     *
     */
    public function deleteAction(Request $request, Appraisement $appraisement)
    {
        $form = $this->createDeleteForm($appraisement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($appraisement);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'appraisement.deleted' );    
        }

        return $this->redirectToRoute('appraisement_index');
    }

    /**
     * Creates a form to delete a Appraisement entity.
     *
     * @param Appraisement $appraisement The Appraisement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Appraisement $appraisement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('appraisement_delete', array('id' => $appraisement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
