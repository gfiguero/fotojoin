<?php

namespace FotoJoin\ControlPanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

class ControlPanelController extends Controller
{

    public function statusAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $em = $this->getDoctrine()->getManager();
        $joinPoints = $em->getRepository('FotoJoinGalleryBundle:Appraisement')->getJoinPointsByUser($user);
        $photoPoints = $em->getRepository('FotoJoinGalleryBundle:Appraisement')->getPhotoPointsByUser($user);

        return $this->render('FotoJoinControlPanelBundle:ControlPanel:status.html.twig', array(
            'joinPointsQuantity' => $joinPoints['quantity'],
            'joinPointsScore' => $joinPoints['score'],
            'photoPointsQuantity' => $photoPoints['quantity'],
            'photoPointsScore' => $photoPoints['score'],
            'photoPointsAverage' => $photoPoints['average'],
            'user' => $user
        ));
    }

    public function selfSetAuthorAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $user->addRole("ROLE_AUTHOR");

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }
}
