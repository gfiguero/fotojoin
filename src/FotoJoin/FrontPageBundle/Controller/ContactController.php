<?php

namespace FotoJoin\FrontPageBundle\Controller;

use FotoJoin\AdminBundle\Entity\Contact;
use FotoJoin\FrontPageBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ContactController extends Controller
{
    public function newAction(Request $request)
    {
        $contact = new Contact();
        $newForm = $this->createNewForm($contact);
        $newForm->handleRequest($request);

        if ($newForm->isSubmitted()) {
            if($newForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($contact);
                $em->flush();
                $request->getSession()->getFlashBag()->add( 'success', 'contact.new.flash' );
                return $this->redirect($this->generateUrl('front_page_contact_new'));
            }
        }

        return $this->render('FotoJoinFrontPageBundle:Contact:new.html.twig', array(
            'newForm' => $newForm->createView(),
        ));
    }

    private function createNewForm(Contact $contact)
    {
        return $this->createForm(new ContactType(), $contact, array(
            'action' => $this->generateUrl('front_page_contact_new'),
        ));
    }

}
