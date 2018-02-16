<?php

namespace FotoJoin\AdminBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function topMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');
        $menu->setChildrenAttribute('id', 'top-menu');
        $menu->addChild('topmenu.admin', array('route' => 'dashboard_index'))->setAttribute('icon', 'cogs fa-fw');
        $menu->addChild('topmenu.logout', array('route' => 'dashboard_index'))->setAttribute('icon', 'sign-out fa-fw');
        $menu->addChild('topmenu.profile', array('route' => 'dashboard_index'))->setAttribute('icon', 'user fa-fw');
        return $menu;
    }

    public function sideMenu(FactoryInterface $factory, array $options)
    {
        $sidemenu = $factory->createItem('root');
        $sidemenu->setChildrenAttribute('class', 'nav nav-pills nav-stacked');
        $sidemenu->setChildrenAttribute('id', 'side-menu');


        $sidemenu->addChild('sidemenu.category', array('route' => 'admin_category_index'))->setExtras(array('translation_domain' => 'FotoJoinAdminBundle', 'routes' => array(
            'admin_category_index',
            'admin_category_new',
            'admin_category_show',
            'admin_category_edit',
            'admin_category_delete',
        )));

        $sidemenu->addChild('sidemenu.city', array('route' => 'admin_city_index'))->setExtras(array('translation_domain' => 'FotoJoinAdminBundle', 'routes' => array(
            'admin_city_index',
            'admin_city_new',
            'admin_city_show',
            'admin_city_edit',
            'admin_city_delete',
        )));

        $sidemenu->addChild('sidemenu.album', array('route' => 'admin_album_index'))->setExtras(array('translation_domain' => 'FotoJoinAdminBundle', 'routes' => array(
            'admin_album_index',
            'admin_album_new',
            'admin_album_show',
            'admin_album_edit',
            'admin_album_delete',
        )));

        $sidemenu->addChild('sidemenu.photography', array('route' => 'admin_photography_index'))->setExtras(array('translation_domain' => 'FotoJoinAdminBundle', 'routes' => array(
            'admin_photography_index',
            'admin_photography_new',
            'admin_photography_show',
            'admin_photography_edit',
            'admin_photography_delete',
        )));

        $sidemenu->addChild('sidemenu.plan', array('route' => 'admin_plan_index'))->setExtras(array('translation_domain' => 'FotoJoinAdminBundle', 'routes' => array(
            'admin_plan_index',
            'admin_plan_new',
            'admin_plan_show',
            'admin_plan_edit',
            'admin_plan_delete',
        )));
        $sidemenu->addChild('sidemenu.user', array('route' => 'admin_user_index'))->setExtras(array('translation_domain' => 'FotoJoinAdminBundle', 'routes' => array(
            'admin_user_index',
            'admin_user_new',
            'admin_user_show',
            'admin_user_edit',
            'admin_user_delete',
        )));
        $sidemenu->addChild('sidemenu.contact', array('route' => 'admin_contact_index'))->setExtras(array('translation_domain' => 'FotoJoinAdminBundle', 'routes' => array(
            'admin_contact_index',
            'admin_contact_new',
            'admin_contact_show',
            'admin_contact_edit',
            'admin_contact_delete',
        )));
/*
        $sidemenu->addChild('sidemenu.dashboard', array('route' => 'dashboard_index'))->setAttribute('icon', 'dashboard fa-fw')->setAttribute('translation_domain', 'FotoJoinAdminBundle');
        $sidemenu->addChild('sidemenu.appraisement', array('route' => 'admin_appraisement_index'))->setAttribute('icon', 'star-half-o fa-fw')->setAttribute('translation_domain', 'FotoJoinAdminBundle');
*/
        return $sidemenu;
    }

}