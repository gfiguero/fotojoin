<?php

namespace FotoJoin\AdminBundle\Controller;

use FotoJoin\AdminBundle\Entity\Category;
use FotoJoin\AdminBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Category controller.
 *
 */
class CategoryController extends Controller
{

    /**
     * Lists all Category entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $categories = $em->getRepository('FotoJoinAdminBundle:Category')->findBy(array(), array($sort => $direction));
        else $categories = $em->getRepository('FotoJoinAdminBundle:Category')->findAll();
        $paginator = $this->get('knp_paginator');
        $categories = $paginator->paginate($categories, $request->query->getInt('page', 1), 100);

        $deleteForms = array();
        foreach($categories as $key => $category) {
            $deleteForms[] = $this->createDeleteForm($category)->createView();
        }

        return $this->render('FotoJoinAdminBundle:Category:index.html.twig', array(
            'categories' => $categories,
            'direction' => $direction,
            'sort' => $sort,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new Category entity.
     *
     */
    public function newAction(Request $request)
    {
        $category = new Category();
        $newForm = $this->createNewForm($category);
        $newForm->handleRequest($request);

        if ($newForm->isSubmitted()) {
            if($newForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'success', 'category.new.flash' );
                return $this->redirect($this->generateUrl('admin_category_index'));
            }
        }

        return $this->render('FotoJoinAdminBundle:Category:new.html.twig', array(
            'newForm' => $newForm->createView(),
        ));
    }

    /**
     * Creates a form to create a new Category entity.
     *
     * @param Category $category The Category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createNewForm(Category $category)
    {
        return $this->createForm(new CategoryType(), $category, array(
            'action' => $this->generateUrl('admin_category_new'),
        ));
    }

    /**
     * Finds and displays a Category entity.
     *
     */
    public function showAction(Category $category)
    {
        $editForm = $this->createEditForm($category);
        $deleteForm = $this->createDeleteForm($category);

        return $this->render('FotoJoinAdminBundle:Category:show.html.twig', array(
            'category' => $category,
            'editForm' => $editForm->createView(),
            'deleteForm' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     */
    public function editAction(Request $request, Category $category)
    {
        $editForm = $this->createEditForm($category);
        $deleteForm = $this->createDeleteForm($category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted()) {
            if($editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'success', 'category.edit.flash' );
                return $this->redirect($this->generateUrl('admin_category_index'));
            }
        }

        return $this->render('FotoJoinAdminBundle:Category:edit.html.twig', array(
            'category' => $category,
            'editForm' => $editForm->createView(),
            'deleteForm' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Category entity.
     *
     * @param Category $category The Category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Category $category)
    {
        return $this->createForm(new CategoryType(), $category, array(
            'action' => $this->generateUrl('admin_category_edit', array('id' => $category->getId())),
        ));
    }

    /**
     * Deletes a Category entity.
     *
     */
    public function deleteAction(Request $request, Category $category)
    {
        $deleteForm = $this->createDeleteForm($category);
        $deleteForm->handleRequest($request);

        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($category);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'category.delete.flash' );
        }

        return $this->redirect($this->generateUrl('admin_category_index'));
    }

    /**
     * Creates a form to delete a Category entity.
     *
     * @param Category $category The Category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_category_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
