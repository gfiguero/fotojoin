<?php

namespace FotoJoin\FrontPageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use FotoJoin\FrontPageBundle\Form\ContactType;

class FrontPageController extends Controller
{
    public function indexAction(Request $request)
    {
        $form = $this->createForm('FotoJoin\FrontPageBundle\Form\ContactType');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $message = \Swift_Message::newInstance()
                ->setSubject('Contacto')
                ->setFrom($form->get('email')->getData())
                ->setTo('garri.figueroa@izarus.cl')
                ->setBody(
                    $this->renderView('FotoJoinUserBundle:Email:Contact.html.twig', array(
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

        return $this->render('FotoJoinFrontPageBundle:FrontPage:frontpage.html.twig', array(
            'form' => $form->createView(),
            'userForm' => $this->createUserForm()->createView(),
            'authorForm' => $this->createAuthorForm()->createView(),
        ));
    }

    public function signupAction() {
        return $this->render('FotoJoinFrontPageBundle:FrontPage:signup.html.twig', array(
            'userForm' => $this->createUserForm()->createView(),
            'authorForm' => $this->createAuthorForm()->createView(),
        ));        
    }

    private function createUserForm()
    {
        $formFactory = $this->get('fos_user.registration.form.factory');
        $userManager = $this->get('fos_user.user_manager');
        $userForm = $formFactory->createForm(array('action' => $this->generateUrl('fos_user_registration_register', array('author' => 0))));
        $userForm->setData($userManager->createUser());
        return $userForm;
    }

    private function createAuthorForm()
    {
        $formFactory = $this->get('fos_user.registration.form.factory');
        $userManager = $this->get('fos_user.user_manager');
        $authorForm = $formFactory->createForm(array('action' => $this->generateUrl('fos_user_registration_register', array('author' => 1))));
        $authorForm->setData($userManager->createUser());
        return $authorForm;
    }

}
