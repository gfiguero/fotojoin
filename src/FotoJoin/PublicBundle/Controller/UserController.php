<?php

namespace FotoJoin\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FotoJoin\UserBundle\Entity\User;

class UserController extends Controller
{
    public function showAction(Request $request, User $user)
    {
        return $this->render('FotoJoinPublicBundle:User:show.html.twig', array(
            'user' => $user,
        ));
    }
}
