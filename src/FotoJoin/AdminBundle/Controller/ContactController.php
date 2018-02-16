<?php

namespace FotoJoin\AdminBundle\Controller;

use FotoJoin\AdminBundle\Entity\Contact;
use FotoJoin\AdminBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Contact controller.
 *
 */
class ContactController extends Controller
{

    /**
     * Lists all Contact entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $contacts = $em->getRepository('FotoJoinAdminBundle:Contact')->findBy(array(), array($sort => $direction));
        else $contacts = $em->getRepository('FotoJoinAdminBundle:Contact')->findAll();
        $paginator = $this->get('knp_paginator');
        $contacts = $paginator->paginate($contacts, $request->query->getInt('page', 1), 100);

        return $this->render('FotoJoinAdminBundle:Contact:index.html.twig', array(
            'contacts' => $contacts,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new Contact entity.
     *
     */
    public function newAction(Request $request)
    {
        $contact = new Contact();
        $newForm = $this->createNewForm($contact);
        $newForm->handleRequest($request);

        if ($newForm->isSubmitted()) {
            if($newForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($contact);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'success', 'contact.new.flash' );
                return $this->redirect($this->generateUrl('admin_contact_index'));
            }
        }

        return $this->render('FotoJoinAdminBundle:Contact:new.html.twig', array(
            'newForm' => $newForm->createView(),
        ));
    }

    /**
     * Creates a form to create a new Contact entity.
     *
     * @param Contact $contact The Contact entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createNewForm(Contact $contact)
    {
        return $this->createForm(new ContactType(), $contact, array(
            'action' => $this->generateUrl('admin_contact_new'),
        ));
    }

    /**
     * Finds and displays a Contact entity.
     *
     */
    public function showAction(Contact $contact)
    {
        $editForm = $this->createEditForm($contact);

        return $this->render('FotoJoinAdminBundle:Contact:show.html.twig', array(
            'contact' => $contact,
        ));
    }

    /**
     * Displays a form to edit an existing Contact entity.
     *
     */
    public function editAction(Request $request, Contact $contact)
    {
        $editForm = $this->createEditForm($contact);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted()) {
            if($editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($contact);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'success', 'contact.edit.flash' );
                return $this->redirect($this->generateUrl('admin_contact_index'));
            }
        }

        return $this->render('FotoJoinAdminBundle:Contact:edit.html.twig', array(
            'contact' => $contact,
            'editForm' => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Contact entity.
     *
     * @param Contact $contact The Contact entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Contact $contact)
    {
        return $this->createForm(new ContactType(), $contact, array(
            'action' => $this->generateUrl('admin_contact_edit', array('id' => $contact->getId())),
        ));
    }

    /**
     * Deletes a Contact entity.
     *
     */
    public function deleteAction(Request $request, Contact $contact)
    {
        $deleteForm = $this->createDeleteForm($contact);
        $deleteForm->handleRequest($request);

        if ($deleteForm->isSubmitted()) {
            if($deleteForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($contact);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'danger', 'contact.delete.flash' );
                return $this->redirect($this->generateUrl('admin_contact_index'));
            }
        }

        return $this->render('FotoJoinAdminBundle:Contact:delete.html.twig', array(
            'contact' => $contact,
            'deleteForm' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a Contact entity.
     *
     * @param Contact $contact The Contact entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Contact $contact)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_contact_delete', array('id' => $contact->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
