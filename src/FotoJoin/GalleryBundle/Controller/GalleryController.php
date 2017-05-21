<?php

namespace FotoJoin\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\Query\Expr;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

use FotoJoin\GalleryBundle\Entity\Gallery;
use FotoJoin\GalleryBundle\Form\GalleryType;

use FotoJoin\GalleryBundle\Entity\Appraisement;
use FotoJoin\GalleryBundle\Form\AppraisementType;

use FotoJoin\ControlPanelBundle\Entity\Photography;

class GalleryController extends Controller
{
    public function indexAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $gallery = new Gallery();
            $form = $this->createForm('FotoJoin\GalleryBundle\Form\GalleryType', $gallery);
            $form->handleRequest($request);
            return $this->render('FotoJoinGalleryBundle:Gallery:filter.html.twig', array(
                'form' => $form->createView(),
            ));
        }

        $gallery = new Gallery();
        $form = $this->createForm('FotoJoin\GalleryBundle\Form\GalleryType', $gallery);
        $form->handleRequest($request);

        $photographies = $this->getDoctrine()->getRepository('FotoJoinControlPanelBundle:Photography')->getPhotographies($gallery);

        return $this->render('FotoJoinGalleryBundle:Gallery:gallery.html.twig', array(
            'photographies'          => $photographies['photographies'],
            'appraisementAverages'   => $photographies['appraisementAverages'],
            'appraisementQuantities' => $photographies['appraisementQuantities'],
            'form'                   => $form->createView(),
        ));

    }

    public function shareAction(Photography $photography)
    {
        $photography = $this->getDoctrine()->getRepository('FotoJoinControlPanelBundle:Photography')->getPhotography($photography);

        return $this->render('FotoJoinGalleryBundle:Gallery:photography.html.twig', array(
            'photography' => $photography['photography'],
            'appraisementAverage' => $photography['appraisementAverage'],
            'appraisementQuantity' => $photography['appraisementQuantity'],
        ));

    }

}
