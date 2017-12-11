<?php

namespace FotoJoin\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FotoJoin\AdminBundle\Entity\Author;
use FotoJoin\AdminBundle\Form\AuthorType;

/**
 * Author controller.
 *
 */
class AuthorController extends Controller
{
    /**
     * Lists all Author entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $authors = $em->getRepository('FotoJoinAdminBundle:Author')->findBy(array(), array($sort => $direction));
        else $authors = $em->getRepository('FotoJoinAdminBundle:Author')->findAll();
        $paginator = $this->get('knp_paginator');
        $authors = $paginator->paginate($authors, $request->query->getInt('page', 1), 10);

        return $this->render('author/index.html.twig', array(
            'authors' => $authors,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new Author entity.
     *
     */
    public function newAction(Request $request)
    {
        $author = new Author();
        $form = $this->createForm('FotoJoin\AdminBundle\Form\AuthorType', $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($author);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'author.created' );    

            return $this->redirectToRoute('author_show', array('id' => $author->getId()));
        }

        return $this->render('author/new.html.twig', array(
            'author' => $author,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Author entity.
     *
     */
    public function showAction(Author $author)
    {
        $deleteForm = $this->createDeleteForm($author);

        return $this->render('author/show.html.twig', array(
            'author' => $author,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Author entity.
     *
     */
    public function editAction(Request $request, Author $author)
    {
        $deleteForm = $this->createDeleteForm($author);
        $editForm = $this->createForm('FotoJoin\AdminBundle\Form\AuthorType', $author);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($author);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'author.edited' );    

            return $this->redirectToRoute('author_edit', array('id' => $author->getId()));
        }

        return $this->render('author/edit.html.twig', array(
            'author' => $author,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Author entity.
     *
     */
    public function deleteAction(Request $request, Author $author)
    {
        $form = $this->createDeleteForm($author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($author);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'author.deleted' );    
        }

        return $this->redirectToRoute('author_index');
    }

    /**
     * Creates a form to delete a Author entity.
     *
     * @param Author $author The Author entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Author $author)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('author_delete', array('id' => $author->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
