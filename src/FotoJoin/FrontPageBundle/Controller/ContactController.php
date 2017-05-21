<?php

namespace FotoJoin\FrontPageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use FotoJoin\FrontPageBundle\Form\ContactType;

class ContactController extends Controller
{
    public function indexAction(Request $request)
    {
        $form = $this->createForm('FotoJoin\FrontPageBundle\Form\ContactType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $from_name = $form->get('nombre')->getData();
            $from_email = $form->get('email')->getData();
            $from = array($from_email => $from_name);
            $message = \Swift_Message::newInstance()
                ->setSubject('Formulario de contacto FotoJoin')
                ->setFrom($from)
                ->setTo('garri.figueroa@izarus.cl')
                ->setBody(
                    $this->renderView('FotoJoinFrontPageBundle:Email:Contact.email.twig', array(
                        'name' => $form->get('nombre')->getData(),
                        'message' => $form->get('mensaje')->getData(),
                        'subject' => $form->get('asunto')->getData(),
                        'email' => $form->get('email')->getData(),
                    )),
                    'text/plain'
                )
            ;
            $this->get('mailer')->send($message);

            return $this->redirectToRoute('foto_join_front_page_homepage');
        }

        return $this->render('FotoJoinFrontPageBundle:Contact:contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
