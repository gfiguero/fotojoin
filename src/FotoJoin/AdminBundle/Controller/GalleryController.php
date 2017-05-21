<?php

namespace FotoJoin\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FotoJoin\AdminBundle\Entity\Gallery;
use FotoJoin\AdminBundle\Form\GalleryType;

/**
 * Gallery controller.
 *
 */
class GalleryController extends Controller
{
    /**
     * Lists all Gallery entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $galleries = $em->getRepository('FotoJoinAdminBundle:Gallery')->findBy(array(), array($sort => $direction));
        else $galleries = $em->getRepository('FotoJoinAdminBundle:Gallery')->findAll();
        $paginator = $this->get('knp_paginator');
        $galleries = $paginator->paginate($galleries, $request->query->getInt('page', 1), 10);

        return $this->render('gallery/index.html.twig', array(
            'galleries' => $galleries,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new Gallery entity.
     *
     */
    public function newAction(Request $request)
    {
        $gallery = new Gallery();
        $form = $this->createForm('FotoJoin\AdminBundle\Form\GalleryType', $gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gallery);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'gallery.created' );    

            return $this->redirectToRoute('gallery_show', array('id' => $gallery->getId()));
        }

        return $this->render('gallery/new.html.twig', array(
            'gallery' => $gallery,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Gallery entity.
     *
     */
    public function showAction(Gallery $gallery)
    {
        $deleteForm = $this->createDeleteForm($gallery);

        return $this->render('gallery/show.html.twig', array(
            'gallery' => $gallery,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Gallery entity.
     *
     */
    public function editAction(Request $request, Gallery $gallery)
    {
        $deleteForm = $this->createDeleteForm($gallery);
        $editForm = $this->createForm('FotoJoin\AdminBundle\Form\GalleryType', $gallery);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gallery);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'gallery.edited' );    

            return $this->redirectToRoute('gallery_edit', array('id' => $gallery->getId()));
        }

        return $this->render('gallery/edit.html.twig', array(
            'gallery' => $gallery,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Gallery entity.
     *
     */
    public function deleteAction(Request $request, Gallery $gallery)
    {
        $form = $this->createDeleteForm($gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($gallery);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'gallery.deleted' );    
        }

        return $this->redirectToRoute('gallery_index');
    }

    /**
     * Creates a form to delete a Gallery entity.
     *
     * @param Gallery $gallery The Gallery entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Gallery $gallery)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gallery_delete', array('id' => $gallery->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
