<?php

namespace FotoJoin\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FotoJoin\AdminBundle\Entity\Place;
use FotoJoin\AdminBundle\Form\PlaceType;

use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Place controller.
 *
 */
class PlaceController extends Controller
{
    /**
     * Lists all Place entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $places = $em->getRepository('FotoJoinAdminBundle:Place')->findBy(array(), array($sort => $direction));
        else $places = $em->getRepository('FotoJoinAdminBundle:Place')->findAll();
        $paginator = $this->get('knp_paginator');
        $places = $paginator->paginate($places, $request->query->getInt('page', 1), 10);

        return $this->render('place/index.html.twig', array(
            'places' => $places,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new Place entity.
     *
     */
    public function newAction(Request $request)
    {
        $place = new Place();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new PlaceType($em), $place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $country = $form->get('country')->getData();
            $cities = $this->getDoctrine()->getManager()->getRepository('FotoJoinAdminBundle:City')->findByCountry($country, array('name' => 'asc'));
            $result = array();
            foreach ($cities as $city) {
                $result[$city->getName()] = $city->getId();
            }
            return new JsonResponse($result);

/*
            $em = $this->getDoctrine()->getManager();
            $em->persist($place);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'place.created' );    

            return $this->redirectToRoute('place_show', array('id' => $place->getId()));
*/
        }

        return $this->render('place/new.html.twig', array(
            'place' => $place,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Place entity.
     *
     */
    public function showAction(Place $place)
    {
        $deleteForm = $this->createDeleteForm($place);

        return $this->render('place/show.html.twig', array(
            'place' => $place,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Place entity.
     *
     */
    public function editAction(Request $request, Place $place)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($place);
        $editForm = $this->createForm(new PlaceType($em), $place);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
        }

        return $this->render('place/edit.html.twig', array(
            'place' => $place,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Place entity.
     *
     */
    public function deleteAction(Request $request, Place $place)
    {
        $form = $this->createDeleteForm($place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($place);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'place.deleted' );    
        }

        return $this->redirectToRoute('place_index');
    }

    /**
     * Creates a form to delete a Place entity.
     *
     * @param Place $place The Place entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Place $place)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('place_delete', array('id' => $place->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
