<?php

namespace FotoJoin\RankingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PhotographyController extends Controller
{
    public function indexAction()
    {
        $photographies = $this->getDoctrine()->getRepository('FotoJoinControlPanelBundle:Photography')->getRanking();

        return $this->render('FotoJoinRankingBundle:Photography:index.html.twig',array(
            'photographies'          => $photographies['photographies'],
            'appraisementAverages'   => $photographies['appraisementAverages'],
            'appraisementQuantities' => $photographies['appraisementQuantities'],
        ));
    }
}
