<?php

namespace FotoJoin\AdminGeneratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FotoJoinAdminGeneratorBundle:Default:index.html.twig');
    }
}
