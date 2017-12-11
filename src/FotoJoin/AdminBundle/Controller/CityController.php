<?php

namespace FotoJoin\AdminBundle\Controller;

use FotoJoin\AdminBundle\Entity\City;
use FotoJoin\AdminBundle\Form\CityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $cities = $em->getRepository('FotoJoinAdminBundle:City')->findBy(array(), array($sort => $direction));
        else $cities = $em->getRepository('FotoJoinAdminBundle:City')->findAll();
        $paginator = $this->get('knp_paginator');
        $cities = $paginator->paginate($cities, $request->query->getInt('page', 1), 100);

        return $this->render('FotoJoinAdminBundle:City:index.html.twig', array(
            'cities' => $cities,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new City entity.
     *
     */
    public function newAction(Request $request)
    {
        $city = new City();
        $newForm = $this->createNewForm($city);
        $newForm->handleRequest($request);

        if ($newForm->isSubmitted()) {
            if($newForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($city);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'success', 'city.new.flash' );
                return $this->redirect($this->generateUrl('admin_city_index'));
            }
        }

        return $this->render('FotoJoinAdminBundle:City:new.html.twig', array(
            'newForm' => $newForm->createView(),
        ));
    }

    /**
     * Creates a form to create a new City entity.
     *
     * @param City $city The City entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createNewForm(City $city)
    {
        return $this->createForm(new CityType(), $city, array(
            'action' => $this->generateUrl('admin_city_new'),
        ));
    }

    /**
     * Finds and displays a City entity.
     *
     */
    public function showAction(City $city)
    {
        $editForm = $this->createEditForm($city);
        $deleteForm = $this->createDeleteForm($city);

        return $this->render('FotoJoinAdminBundle:City:show.html.twig', array(
            'city' => $city,
            'editForm' => $editForm->createView(),
            'deleteForm' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing City entity.
     *
     */
    public function editAction(Request $request, City $city)
    {
        $editForm = $this->createEditForm($city);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted()) {
            if($editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($city);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'success', 'city.edit.flash' );
                return $this->redirect($this->generateUrl('admin_city_index'));
            }
        }

        return $this->render('FotoJoinAdminBundle:City:edit.html.twig', array(
            'city' => $city,
            'editForm' => $editForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a City entity.
     *
     * @param City $city The City entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(City $city)
    {
        return $this->createForm(new CityType(), $city, array(
            'action' => $this->generateUrl('admin_city_edit', array('id' => $city->getId())),
        ));
    }

    /**
     * Deletes a City entity.
     *
     */
    public function deleteAction(Request $request, City $city)
    {
        $deleteForm = $this->createDeleteForm($city);
        $deleteForm->handleRequest($request);

        if ($deleteForm->isSubmitted()) {
            if($deleteForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($city);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'danger', 'city.delete.flash' );
                return $this->redirect($this->generateUrl('admin_city_index'));
            }
        }

        return $this->render('FotoJoinAdminBundle:City:delete.html.twig', array(
            'city' => $city,
            'deleteForm' => $deleteForm->createView(),
        ));
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
            ->setAction($this->generateUrl('admin_city_delete', array('id' => $city->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
