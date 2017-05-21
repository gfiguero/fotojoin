<?php

namespace FotoJoin\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FotoJoin\AdminBundle\Entity\Album;
use FotoJoin\AdminBundle\Form\AlbumType;

/**
 * Album controller.
 *
 */
class AlbumController extends Controller
{
    /**
     * Lists all Album entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $albums = $em->getRepository('FotoJoinAdminBundle:Album')->findBy(array(), array($sort => $direction));
        else $albums = $em->getRepository('FotoJoinAdminBundle:Album')->findAll();
        $paginator = $this->get('knp_paginator');
        $albums = $paginator->paginate($albums, $request->query->getInt('page', 1), 10);

        return $this->render('album/index.html.twig', array(
            'albums' => $albums,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new Album entity.
     *
     */
    public function newAction(Request $request)
    {
        $album = new Album();
        $form = $this->createForm('FotoJoin\AdminBundle\Form\AlbumType', $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($album);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'album.created' );    

            return $this->redirectToRoute('album_show', array('id' => $album->getId()));
        }

        return $this->render('album/new.html.twig', array(
            'album' => $album,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Album entity.
     *
     */
    public function showAction(Album $album)
    {
        $deleteForm = $this->createDeleteForm($album);

        return $this->render('album/show.html.twig', array(
            'album' => $album,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Album entity.
     *
     */
    public function editAction(Request $request, Album $album)
    {
        $deleteForm = $this->createDeleteForm($album);
        $editForm = $this->createForm('FotoJoin\AdminBundle\Form\AlbumType', $album);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($album);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'album.edited' );    

            return $this->redirectToRoute('album_edit', array('id' => $album->getId()));
        }

        return $this->render('album/edit.html.twig', array(
            'album' => $album,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Album entity.
     *
     */
    public function deleteAction(Request $request, Album $album)
    {
        $form = $this->createDeleteForm($album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($album);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'album.deleted' );    
        }

        return $this->redirectToRoute('album_index');
    }

    /**
     * Creates a form to delete a Album entity.
     *
     * @param Album $album The Album entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Album $album)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('album_delete', array('id' => $album->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
