<?php

namespace FotoJoin\AdminBundle\Controller;

use FotoJoin\GalleryBundle\Entity\Appraisement;
use FotoJoin\AdminBundle\Form\AppraisementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        if($sort) $appraisements = $em->getRepository('FotoJoinGalleryBundle:Appraisement')->findBy(array(), array($sort => $direction));
        else $appraisements = $em->getRepository('FotoJoinGalleryBundle:Appraisement')->findAll();
        $paginator = $this->get('knp_paginator');
        $appraisements = $paginator->paginate($appraisements, $request->query->getInt('page', 1), 100);

        $deleteForms = array();
        foreach($appraisements as $key => $appraisement) {
            $deleteForms[] = $this->createDeleteForm($appraisement)->createView();
        }

        return $this->render('FotoJoinAdminBundle:Appraisement:index.html.twig', array(
            'appraisements' => $appraisements,
            'direction' => $direction,
            'sort' => $sort,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new Appraisement entity.
     *
     */
    public function newAction(Request $request)
    {
        $appraisement = new Appraisement();
        $newForm = $this->createNewForm($appraisement);
        $newForm->handleRequest($request);

        if ($newForm->isSubmitted()) {
            if($newForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($appraisement);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'success', 'appraisement.new.flash' );
                return $this->redirect($this->generateUrl('admin_appraisement_index'));
            }
        }

        return $this->render('FotoJoinAdminBundle:Appraisement:new.html.twig', array(
            'newForm' => $newForm->createView(),
        ));
    }

    /**
     * Creates a form to create a new Appraisement entity.
     *
     * @param Appraisement $appraisement The Appraisement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createNewForm(Appraisement $appraisement)
    {
        return $this->createForm(new AppraisementType(), $appraisement, array(
            'action' => $this->generateUrl('admin_appraisement_new'),
        ));
    }

    /**
     * Finds and displays a Appraisement entity.
     *
     */
    public function showAction(Appraisement $appraisement)
    {
        $editForm = $this->createEditForm($appraisement);
        $deleteForm = $this->createDeleteForm($appraisement);

        return $this->render('FotoJoinAdminBundle:Appraisement:show.html.twig', array(
            'appraisement' => $appraisement,
            'editForm' => $editForm->createView(),
            'deleteForm' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Appraisement entity.
     *
     */
    public function editAction(Request $request, Appraisement $appraisement)
    {
        $editForm = $this->createEditForm($appraisement);
        $deleteForm = $this->createDeleteForm($appraisement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted()) {
            if($editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($appraisement);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'success', 'appraisement.edit.flash' );
                return $this->redirect($this->generateUrl('admin_appraisement_index'));
            }
        }

        return $this->render('FotoJoinAdminBundle:Appraisement:edit.html.twig', array(
            'appraisement' => $appraisement,
            'editForm' => $editForm->createView(),
            'deleteForm' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Appraisement entity.
     *
     * @param Appraisement $appraisement The Appraisement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Appraisement $appraisement)
    {
        return $this->createForm(new AppraisementType(), $appraisement, array(
            'action' => $this->generateUrl('admin_appraisement_edit', array('id' => $appraisement->getId())),
        ));
    }

    /**
     * Deletes a Appraisement entity.
     *
     */
    public function deleteAction(Request $request, Appraisement $appraisement)
    {
        $deleteForm = $this->createDeleteForm($appraisement);
        $deleteForm->handleRequest($request);

        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($appraisement);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'appraisement.delete.flash' );
        }

        return $this->redirect($this->generateUrl('admin_appraisement_index'));
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
            ->setAction($this->generateUrl('admin_appraisement_delete', array('id' => $appraisement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
