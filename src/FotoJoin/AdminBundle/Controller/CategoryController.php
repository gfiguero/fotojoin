<?php

namespace FotoJoin\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Model\UserInterface;

use FotoJoin\AdminBundle\Entity\Category;
use FotoJoin\AdminBundle\Form\CategoryType;

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
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $categories = $em->getRepository('FotoJoinAdminBundle:Category')->findBy(array(), array($sort => $direction));
        else $categories = $em->getRepository('FotoJoinAdminBundle:Category')->findAll();
        $paginator = $this->get('knp_paginator');
        $categories = $paginator->paginate($categories, $request->query->getInt('page', 1), 10);

        $category = new Category();
        $newForm = $this->createForm('FotoJoin\AdminBundle\Form\CategoryType', $category, array('action' => $this->generateUrl('category_new')))->createView();
        $editForms = array();
        $deleteForms = array();
        foreach ($categories as $category) {
            $deleteForms[] = $this->createDeleteForm($category)->createView();
            $editForms[] = $this->createEditForm($category)->createView();
        }

        return $this->render('FotoJoinAdminBundle:Admin:category.html.twig', array(
            'user' => $user,
            'categories' => $categories,
            'direction' => $direction,
            'sort' => $sort,
            'newForm' => $newForm,
            'deleteForms' => $deleteForms,
            'editForms' => $editForms,
        ));
    }

    /**
     * Creates a new Category entity.
     *
     */
    public function newAction(Request $request)
    {
        $category = new Category();
        $newForm = $this->createForm('FotoJoin\AdminBundle\Form\CategoryType', $category);
        $newForm->handleRequest($request);

        if ($newForm->isSubmitted() && $newForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'category.created' );    

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->redirect($request->headers->get('referer'));

    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     */
    public function editAction(Request $request, Category $category)
    {
        $editForm = $this->createForm('FotoJoin\AdminBundle\Form\CategoryType', $category);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'category.edited' );    

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->redirect($request->headers->get('referer'));
    }

    private function createEditForm(Category $category)
    {
        return $this->createForm('FotoJoin\AdminBundle\Form\CategoryType', $category, array(
            'action' => $this->generateUrl('category_edit', array('id' => $category->getId()))
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
            $request->getSession()->getFlashBag()->add( 'danger', 'category.deleted' );    
        }

        return $this->redirectToRoute('category_index');
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
            ->setAction($this->generateUrl('category_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
