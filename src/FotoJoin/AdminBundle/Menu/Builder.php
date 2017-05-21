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
        $menu->addChild('admin.config', array(
            'route' => 'dashboard_index',
            'attributes' => array(
                'icon' => 'cogs fa-fw'
            )
        ));
        $menu->addChild('admin.logout', array('route' => 'dashboard_index'))->setAttribute('icon', 'sign-out fa-fw');
        $menu->addChild('admin.profile', array('route' => 'dashboard_index'))->setAttribute('icon', 'user fa-fw');
//        $menu->addChild('user_profile', array('route' => 'member_index'))->setAttribute('icon', 'user fa-fw');
//        $menu->addChild('user_index', array('route' => 'member_index'))->setAttribute('icon', 'group fa-fw');
//        $menu->addChild('logout', array('route' => 'member_index'))->setAttribute('icon', ' fa-fw');

        return $menu;

    }

    public function sideMenu(FactoryInterface $factory, array $options)
    {

        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');
        $menu->setChildrenAttribute('id', 'side-menu');

        $menu->addChild('admin.dashboard', array('route' => 'dashboard_index'))->setAttribute('icon', 'dashboard fa-fw');
//        $menu->addChild('dashboard')->setAttribute('icon', 'dashboard fa-fw');
//        $menu['dashboard']->setChildrenAttribute('class', 'nav nav-second-level collapse');
//        $menu['dashboard']->addChild('dashboard.stadistics', array('route' => 'foto_join_admin_homepage'));
//        $menu['dashboard']->addChild('dashboard.general', array('route' => 'foto_join_admin_homepage'));

//        $menu->addChild('member', array('route' => 'foto_join_admin_homepage'))->setAttribute('icon', 'users fa-fw');
//        $menu->addChild('admin.author', array('route' => 'author_index'))->setAttribute('icon', 'copyright fa-fw');
//        $menu->addChild('admin.appraisement', array('route' => 'appraisement_index'))->setAttribute('icon', 'star-half-o fa-fw');
//        $menu->addChild('admin.capture', array('route' => 'capture_index'))->setAttribute('icon', 'camera fa-fw');
        $menu->addChild('admin.category', array('route' => 'category_index'))->setAttribute('icon', 'check-square fa-fw');
//        $menu->addChild('admin.datetime', array('route' => 'datetime_index'))->setAttribute('icon', 'calendar fa-fw');
//        $menu->addChild('admin.place', array('route' => 'place_index'))->setAttribute('icon', 'map-marker fa-fw');
//        $menu->addChild('admin.tag', array('route' => 'tag_index'))->setAttribute('icon', 'tags fa-fw');
//        $menu->addChild('admin.album', array('route' => 'album_index'))->setAttribute('icon', 'picture-o fa-fw');
//        $menu->addChild('admin.photography', array('route' => 'photography_index'))->setAttribute('icon', 'picture-o fa-fw');
//        $menu->addChild('admin.gallery', array('route' => 'gallery_index'))->setAttribute('icon', 'picture-o fa-fw');
        $menu->addChild('admin.city', array('route' => 'city_index'))->setAttribute('icon', 'map-marker fa-fw');


//        $menu->addChild('appraisement', array('route' => 'foto_join_admin_homepage'))->setAttribute('icon', 'star-half-o fa-fw');
//        $menu->addChild('shot', array('route' => 'foto_join_admin_homepage'))->setAttribute('icon', 'camera fa-fw');
//        $menu->addChild('tag', array('route' => 'foto_join_admin_homepage'))->setAttribute('icon', 'tags fa-fw');
//        $menu->addChild('album', array('route' => 'foto_join_admin_homepage'))->setAttribute('icon', 'book fa-fw');
//        $menu->addChild('category', array('route' => 'foto_join_admin_homepage'))->setAttribute('icon', 'check-square fa-fw');


//        $menu->addChild('photo.index', array('route' => 'member_index'))->setAttribute('icon', 'photo fa-fw');
//        $menu->addChild('process_index', array('route' => 'member_index'))->setAttribute('icon', 'paper-plane fa-fw');
//        $menu->addChild('member_control')->setAttribute('icon', 'sitemap fa-fw');
//        $menu['member_control']->addChild('memberrole_index', array('route' => 'member_index'));

//        $menu->addChild('notice_control')->setAttribute('icon', 'newspaper-o fa-fw');
//        $menu['notice_control']->setChildrenAttribute('class', 'nav nav-second-level collapse');
//        $menu['notice_control']->addChild('notice_index', array('route' => 'member_index'));
//        $menu['notice_control']->addChild('noticecategory_index', array('route' => 'member_index'));

//        $menu->addChild('publication_index', array('route' => 'member_index'))->setAttribute('icon', 'bullhorn fa-fw');
//        $menu->addChild('report_index', array('route' => 'member_index'))->setAttribute('icon', 'flag fa-fw');
//        $menu->addChild('document_index', array('route' => 'member_index'))->setAttribute('icon', 'check fa-fw');
//        $menu->addChild('link_index', array('route' => 'member_index'))->setAttribute('icon', 'external-link fa-fw');

        return $menu;

    }

}