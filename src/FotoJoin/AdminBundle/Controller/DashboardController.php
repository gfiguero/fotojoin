<?php

namespace FotoJoin\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render(':Admin:dashboard.html.twig');
    }
}
