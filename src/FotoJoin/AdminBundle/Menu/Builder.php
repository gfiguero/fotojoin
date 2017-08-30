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
        $menu->addChild('admin.config', array('route' => 'dashboard_index'))->setAttribute('icon', 'cogs fa-fw');
        $menu->addChild('topmenu.logout', array('route' => 'dashboard_index'))->setAttribute('icon', 'sign-out fa-fw');
        $menu->addChild('topmenu.profile', array('route' => 'dashboard_index'))->setAttribute('icon', 'user fa-fw');
        return $menu;
    }

    public function sideMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');
        $menu->setChildrenAttribute('id', 'side-menu');
        $menu->addChild('sidemenu.dashboard', array('route' => 'dashboard_index'))->setAttribute('icon', 'dashboard fa-fw')->setAttribute('translation_domain', 'FotoJoinAdminBundle');
        $menu->addChild('sidemenu.category', array('route' => 'admin_category_index'))->setAttribute('icon', 'check-square fa-fw')->setAttribute('translation_domain', 'FotoJoinAdminBundle');
        $menu->addChild('sidemenu.city', array('route' => 'admin_city_index'))->setAttribute('icon', 'map-marker fa-fw')->setAttribute('translation_domain', 'FotoJoinAdminBundle');
        $menu->addChild('sidemenu.user', array('route' => 'admin_user_index'))->setAttribute('icon', 'user fa-fw')->setAttribute('translation_domain', 'FotoJoinAdminBundle');
        $menu->addChild('sidemenu.album', array('route' => 'admin_album_index'))->setAttribute('icon', 'book fa-fw')->setAttribute('translation_domain', 'FotoJoinAdminBundle');
        $menu->addChild('sidemenu.photography', array('route' => 'admin_photography_index'))->setAttribute('icon', 'picture-o fa-fw')->setAttribute('translation_domain', 'FotoJoinAdminBundle');
        $menu->addChild('sidemenu.appraisement', array('route' => 'admin_appraisement_index'))->setAttribute('icon', 'star-half-o fa-fw')->setAttribute('translation_domain', 'FotoJoinAdminBundle');
        return $menu;
    }

}