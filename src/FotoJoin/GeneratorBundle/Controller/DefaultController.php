<?php

namespace FotoJoin\GeneratorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FotoJoinGeneratorBundle:Default:index.html.twig');
    }
}
