<?php

namespace FotoJoin\ControlPanelBundle\Controller;

use FotoJoin\ControlPanelBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Model\UserInterface;
use FotoJoin\UserBundle\Entity\User;

/**
 * Message controller.
 *
 */
class MessageController extends Controller
{
    /**
     * Lists all message entities.
     *
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('FotoJoinControlPanelBundle:Message')->findAll();
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $messages = $em->getRepository('FotoJoinControlPanelBundle:Album')->findBy(array('receiver' => $user), array($sort => $direction));
        else $messages = $em->getRepository('FotoJoinControlPanelBundle:Message')->findBy(array('receiver' => $user));
        $paginator = $this->get('knp_paginator');
        $messages = $paginator->paginate($messages, $request->query->getInt('page', 1), 100);


        return $this->render('FotoJoinControlPanelBundle:Message:index.html.twig', array(
            'direction' => $direction,
            'sort' => $sort,
            'user' => $user,
            'messages' => $messages,
        ));
    }

    /**
     * Creates a new message entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $message = new Message();
        $form = $this->createForm('FotoJoin\ControlPanelBundle\Form\MessageType', $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('message_show', array('id' => $message->getId()));
        }

        return $this->render('FotoJoinControlPanelBundle:Message:new.html.twig', array(
            'message' => $message,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new message entity.
     *
     */
    public function contactAction(Request $request, User $transmitter)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $message = new Message();
        $message->setReceiver($user);
        $message->setTransmitter($transmitter);

        $messageForm = $this->createForm('FotoJoin\ControlPanelBundle\Form\MessageType', $message);
        $messageForm->handleRequest($request);

        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
        }

        return $this->render('FotoJoinControlPanelBundle:Message:contact.html.twig', array(
            'user' => $user,
            'messageForm' => $messageForm->createView(),
        ));
    }

    /**
     * Finds and displays a message entity.
     *
     */
    public function showAction(Message $message)
    {
        $deleteForm = $this->createDeleteForm($message);

        return $this->render('FotoJoinControlPanelBundle:Message:show.html.twig', array(
            'message' => $message,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing message entity.
     *
     */
    public function editAction(Request $request, Message $message)
    {
        $deleteForm = $this->createDeleteForm($message);
        $editForm = $this->createForm('FotoJoin\ControlPanelBundle\Form\MessageType', $message);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('message_edit', array('id' => $message->getId()));
        }

        return $this->render('FotoJoinControlPanelBundle:Message:edit.html.twig', array(
            'message' => $message,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a message entity.
     *
     */
    public function deleteAction(Request $request, Message $message)
    {
        $form = $this->createDeleteForm($message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($message);
            $em->flush();
        }

        return $this->redirectToRoute('message_index');
    }

    /**
     * Creates a form to delete a message entity.
     *
     * @param Message $message The message entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Message $message)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('message_delete', array('id' => $message->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
