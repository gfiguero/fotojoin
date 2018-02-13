<?php

namespace FotoJoin\AdminBundle\Controller;

use FotoJoin\AdminBundle\Entity\Plan;
use FotoJoin\AdminBundle\Form\PlanType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Plan controller.
 *
 */
class PlanController extends Controller
{

    /**
     * Lists all Plan entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $plans = $em->getRepository('FotoJoinAdminBundle:Plan')->findBy(array(), array($sort => $direction));
        else $plans = $em->getRepository('FotoJoinAdminBundle:Plan')->findAll();
        $paginator = $this->get('knp_paginator');
        $plans = $paginator->paginate($plans, $request->query->getInt('page', 1), 100);

        $deleteForms = array();
        foreach($plans as $key => $plan) {
            $deleteForms[] = $this->createDeleteForm($plan)->createView();
        }

        return $this->render('FotoJoinAdminBundle:Plan:index.html.twig', array(
            'plans' => $plans,
            'direction' => $direction,
            'sort' => $sort,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new Plan entity.
     *
     */
    public function newAction(Request $request)
    {
        $plan = new Plan();
        $newForm = $this->createNewForm($plan);
        $newForm->handleRequest($request);

        if ($newForm->isSubmitted()) {
            if($newForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($plan);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'success', 'plan.new.flash' );
                return $this->redirect($this->generateUrl('admin_plan_index'));
            }
        }

        return $this->render('FotoJoinAdminBundle:Plan:new.html.twig', array(
            'newForm' => $newForm->createView(),
        ));
    }

    /**
     * Creates a form to create a new Plan entity.
     *
     * @param Plan $plan The Plan entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createNewForm(Plan $plan)
    {
        return $this->createForm(new PlanType(), $plan, array(
            'action' => $this->generateUrl('admin_plan_new'),
        ));
    }

    /**
     * Finds and displays a Plan entity.
     *
     */
    public function showAction(Plan $plan)
    {
        $editForm = $this->createEditForm($plan);
        $deleteForm = $this->createDeleteForm($plan);

        return $this->render('FotoJoinAdminBundle:Plan:show.html.twig', array(
            'plan' => $plan,
            'editForm' => $editForm->createView(),
            'deleteForm' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Plan entity.
     *
     */
    public function editAction(Request $request, Plan $plan)
    {
        $editForm = $this->createEditForm($plan);
        $deleteForm = $this->createDeleteForm($plan);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted()) {
            if($editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($plan);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'success', 'plan.edit.flash' );
                return $this->redirect($this->generateUrl('admin_plan_index'));
            }
        }

        return $this->render('FotoJoinAdminBundle:Plan:edit.html.twig', array(
            'plan' => $plan,
            'editForm' => $editForm->createView(),
            'deleteForm' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Plan entity.
     *
     * @param Plan $plan The Plan entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Plan $plan)
    {
        return $this->createForm(new PlanType(), $plan, array(
            'action' => $this->generateUrl('admin_plan_edit', array('id' => $plan->getId())),
        ));
    }

    /**
     * Deletes a Plan entity.
     *
     */
    public function deleteAction(Request $request, Plan $plan)
    {
        $deleteForm = $this->createDeleteForm($plan);
        $deleteForm->handleRequest($request);

        if ($deleteForm->isSubmitted()) {
            if($deleteForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($plan);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'danger', 'plan.delete.flash' );
                return $this->redirect($this->generateUrl('admin_plan_index'));
            }
        }

        return $this->render('FotoJoinAdminBundle:Plan:delete.html.twig', array(
            'plan' => $plan,
            'deleteForm' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a Plan entity.
     *
     * @param Plan $plan The Plan entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Plan $plan)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_plan_delete', array('id' => $plan->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
