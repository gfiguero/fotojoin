<?php

namespace FotoJoin\RankingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use FotoJoin\UserBundle\Entity\User;
use FotoJoin\AdminBundle\Entity\Region;
use FotoJoin\AdminBundle\Entity\Province;
use FotoJoin\AdminBundle\Entity\Commune;

class PhotographerController extends Controller
{
    public function indexAction(Request $request, Region $region = null, Province $province = null, Commune $commune = null)
    {
        $photographers = $this->getDoctrine()->getRepository('FotoJoinUserBundle:User')->getRanking($region, $province, $commune);
        $regions = $this->getDoctrine()->getRepository('FotoJoinAdminBundle:Region')->getActive();
        $provinces = $this->getDoctrine()->getRepository('FotoJoinAdminBundle:Province')->getActive($region);
        $communes = $this->getDoctrine()->getRepository('FotoJoinAdminBundle:Commune')->getActive($province);

        return $this->render('FotoJoinRankingBundle:Photographer:index.html.twig',array(
            'region' => $region,
            'province' => $province,
            'commune' => $commune,
            'photographers'          => $photographers['photographers'],
            'appraisementAverages'   => $photographers['appraisementAverages'],
            'appraisementQuantities' => $photographers['appraisementQuantities'],
            'regions' => $regions,
            'provinces' => $provinces,
            'communes' => $communes,
        ));
    }

    public function showAction(Request $request, User $user)
    {
        $appraisementValue = $this->getDoctrine()->getRepository('FotoJoinUserBundle:User')->getAppraisementValue($user);
        $appraisementCount = $this->getDoctrine()->getRepository('FotoJoinUserBundle:User')->getAppraisementCount($user);
        $commune = $user->getCommune();
        $province = $commune->getProvince();
        $region = $province->getRegion();

        return $this->render('FotoJoinRankingBundle:Photographer:show.html.twig',array(
            'user' => $user,
            'region' => $region,
            'province' => $province,
            'commune' => $commune,
            'appraisementValue' => $appraisementValue,
            'appraisementCount' => $appraisementCount,
        ));
    }

}
