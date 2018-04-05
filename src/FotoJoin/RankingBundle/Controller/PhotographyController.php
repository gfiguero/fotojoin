<?php

namespace FotoJoin\RankingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use FotoJoin\ControlPanelBundle\Entity\Photography;
use FotoJoin\AdminBundle\Entity\Region;
use FotoJoin\AdminBundle\Entity\Province;
use FotoJoin\AdminBundle\Entity\Commune;

class PhotographyController extends Controller
{
    public function indexAction(Request $request, Region $region = null, Province $province = null, Commune $commune = null)
    {
        $photographies = $this->getDoctrine()->getRepository('FotoJoinControlPanelBundle:Photography')->getRanking($region, $province, $commune);
        $regions = $this->getDoctrine()->getRepository('FotoJoinAdminBundle:Region')->getActive();
        $provinces = $this->getDoctrine()->getRepository('FotoJoinAdminBundle:Province')->getActive($region);
        $communes = $this->getDoctrine()->getRepository('FotoJoinAdminBundle:Commune')->getActive($province);

        return $this->render('FotoJoinRankingBundle:Photography:index.html.twig',array(
            'region' => $region,
            'province' => $province,
            'commune' => $commune,
            'photographies'          => $photographies['photographies'],
            'appraisementAverages'   => $photographies['appraisementAverages'],
            'appraisementQuantities' => $photographies['appraisementQuantities'],
            'regions' => $regions,
            'provinces' => $provinces,
            'communes' => $communes,
        ));
    }

    public function showAction(Request $request, Photography $photography)
    {
        $photography = $this->getDoctrine()->getRepository('FotoJoinControlPanelBundle:Photography')->find($photography);
        $appraisementValue = $this->getDoctrine()->getRepository('FotoJoinControlPanelBundle:Photography')->getAppraisementValue($photography);
        $appraisementCount = $this->getDoctrine()->getRepository('FotoJoinControlPanelBundle:Photography')->getAppraisementCount($photography);
        $photographies = $photography->getAlbum()->getPhotographies();
        $user = $photography->getUser();
        $commune = $user->getCommune();
        $province = $commune->getProvince();
        $region = $province->getRegion();

        return $this->render('FotoJoinRankingBundle:Photography:show.html.twig',array(
            'photography' => $photography,
            'user' => $user,
            'region' => $region,
            'province' => $province,
            'commune' => $commune,
            'appraisementValue' => $appraisementValue,
            'appraisementCount' => $appraisementCount,
            'photographies' => $photographies,
        ));
    }

}
