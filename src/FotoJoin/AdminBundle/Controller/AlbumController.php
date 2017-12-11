<?php

namespace FotoJoin\AdminBundle\Controller;

use FotoJoin\ControlPanelBundle\Entity\Album;
use FotoJoin\AdminBundle\Form\AlbumType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        if($sort) $albums = $em->getRepository('FotoJoinControlPanelBundle:Album')->findBy(array(), array($sort => $direction));
        else $albums = $em->getRepository('FotoJoinControlPanelBundle:Album')->findAll();
        $paginator = $this->get('knp_paginator');
        $albums = $paginator->paginate($albums, $request->query->getInt('page', 1), 100);

        return $this->render('FotoJoinAdminBundle:Album:index.html.twig', array(
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
        $newForm = $this->createNewForm($album);
        $newForm->handleRequest($request);

        if ($newForm->isSubmitted()) {
            if($newForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($album);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'success', 'album.new.flash' );
                return $this->redirect($this->generateUrl('admin_album_index'));
            }
        }

        return $this->render('FotoJoinAdminBundle:Album:new.html.twig', array(
            'newForm' => $newForm->createView(),
        ));
    }

    /**
     * Creates a form to create a new Album entity.
     *
     * @param Album $album The Album entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createNewForm(Album $album)
    {
        return $this->createForm(new AlbumType(), $album, array(
            'action' => $this->generateUrl('admin_album_new'),
        ));
    }

    /**
     * Finds and displays a Album entity.
     *
     */
    public function showAction(Album $album)
    {
        $editForm = $this->createEditForm($album);
        $deleteForm = $this->createDeleteForm($album);

        return $this->render('FotoJoinAdminBundle:Album:show.html.twig', array(
            'album' => $album,
            'editForm' => $editForm->createView(),
            'deleteForm' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Album entity.
     *
     */
    public function editAction(Request $request, Album $album)
    {
        $editForm = $this->createEditForm($album);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted()) {
            if($editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($album);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'success', 'album.edit.flash' );
                return $this->redirect($this->generateUrl('admin_album_index'));
            }
        }

        return $this->render('FotoJoinAdminBundle:Album:edit.html.twig', array(
            'album' => $album,
            'editForm' => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Album entity.
     *
     * @param Album $album The Album entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Album $album)
    {
        return $this->createForm(new AlbumType(), $album, array(
            'action' => $this->generateUrl('admin_album_edit', array('id' => $album->getId())),
        ));
    }

    /**
     * Deletes a Album entity.
     *
     */
    public function deleteAction(Request $request, Album $album)
    {
        $deleteForm = $this->createDeleteForm($album);
        $deleteForm->handleRequest($request);

        if ($deleteForm->isSubmitted()) {
            if($deleteForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($album);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'danger', 'album.delete.flash' );
                return $this->redirect($this->generateUrl('admin_album_index'));
            }
        }

        return $this->render('FotoJoinAdminBundle:Album:delete.html.twig', array(
            'album' => $album,
            'deleteForm' => $deleteForm->createView(),
        ));
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
            ->setAction($this->generateUrl('admin_album_delete', array('id' => $album->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
