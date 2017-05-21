<?php

namespace FotoJoin\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Model\UserInterface;

use FotoJoin\AdminBundle\Entity\City;
use FotoJoin\AdminBundle\Form\CityType;

/**
 * City controller.
 *
 */
class CityController extends Controller
{
    /**
     * Lists all City entities.
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
        if($sort) $cities = $em->getRepository('FotoJoinAdminBundle:City')->findBy(array(), array($sort => $direction));
        else $cities = $em->getRepository('FotoJoinAdminBundle:City')->findAll();
        $paginator = $this->get('knp_paginator');
        $cities = $paginator->paginate($cities, $request->query->getInt('page', 1), 10);

        $city = new City();
        $newForm = $this->createForm('FotoJoin\AdminBundle\Form\CityType', $city, array('action' => $this->generateUrl('city_new')))->createView();
        $editForms = array();
        $deleteForms = array();
        foreach ($cities as $city) {
            $deleteForms[] = $this->createDeleteForm($city)->createView();
            $editForms[] = $this->createEditForm($city)->createView();
        }

        return $this->render('FotoJoinAdminBundle:Admin:city.html.twig', array(
            'user' => $user,
            'cities' => $cities,
            'direction' => $direction,
            'sort' => $sort,
            'newForm' => $newForm,
            'deleteForms' => $deleteForms,
            'editForms' => $editForms,
        ));
    }

    private function createEditForm(City $city)
    {
        return $this->createForm('FotoJoin\AdminBundle\Form\CityType', $city, array(
            'action' => $this->generateUrl('city_edit', array('id' => $city->getId()))
        ));
    }

    /**
     * Creates a new City entity.
     *
     */
    public function newAction(Request $request)
    {
        $city = new City();
        $form = $this->createForm('FotoJoin\AdminBundle\Form\CityType', $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($city);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'city.created' );    

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Finds and displays a City entity.
     *
     */
    public function showAction(City $city)
    {
        $deleteForm = $this->createDeleteForm($city);

        return $this->render('city/show.html.twig', array(
            'city' => $city,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing City entity.
     *
     */
    public function editAction(Request $request, City $city)
    {
        $deleteForm = $this->createDeleteForm($city);
        $editForm = $this->createForm('FotoJoin\AdminBundle\Form\CityType', $city);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($city);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'city.edited' );    

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Deletes a City entity.
     *
     */
    public function deleteAction(Request $request, City $city)
    {
        $form = $this->createDeleteForm($city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($city);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'city.deleted' );    
        }

        return $this->redirectToRoute('city_index');
    }

    /**
     * Creates a form to delete a City entity.
     *
     * @param City $city The City entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(City $city)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('city_delete', array('id' => $city->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
