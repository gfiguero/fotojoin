<?php

namespace FotoJoin\FrontPageBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function topMenu(FactoryInterface $factory, array $options)
    {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $roles = array();
        if($user instanceof Object) $roles = $user->getRoles();
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');
        $menu->setChildrenAttribute('id', 'top-menu');
//        $menu->addChild('link.timeline', array('route' => '#timeline'))->setAttribute('translation_domain', 'FotoJoinFrontPageBundle');
        $menu->addChild('link.gallery', array('route' => 'foto_join_gallery_homepage'))->setExtra('translation_domain', 'FotoJoinFrontPageBundle');
        $menu->addChild('link.login', array('route' => 'fos_user_security_login'))->setExtra('translation_domain', 'FotoJoinFrontPageBundle');
        $menu->addChild('link.signup', array('route' => 'fos_user_registration_register'))->setExtra('translation_domain', 'FotoJoinFrontPageBundle');
        return $menu;

    }

    public function sideAdminMenu(FactoryInterface $factory, array $options)
    {

        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');
        $menu->setChildrenAttribute('id', 'side-menu');
        $menu->addChild('member.index', array('route' => 'member_index'))->setAttribute('icon', 'users fa-fw');
        $menu->addChild('photo.index', array('route' => 'member_index'))->setAttribute('icon', 'photo fa-fw');
//        $menu->addChild('process_index', array('route' => 'member_index'))->setAttribute('icon', 'paper-plane fa-fw');
//        $menu->addChild('member_control')->setAttribute('icon', 'sitemap fa-fw');
//        $menu['member_control']->setChildrenAttribute('class', 'nav nav-second-level collapse');
//        $menu['member_control']->addChild('member_index', array('route' => 'member_index'));
//        $menu['member_control']->addChild('memberrole_index', array('route' => 'member_index'));
//        $menu['member_control']->addChild('membercourse_index', array('route' => 'member_index'));
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

    public function bottomContactMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');
        $menu->setChildrenAttribute('id', 'contact-menu');
        $menu->addChild('aboutUs', array('route' => 'foto_join_front_page_homepage', 'routeParameters' => array('item' => 'about_us')));
        $menu->addChild('contact', array('route' => 'foto_join_front_page_homepage', 'routeParameters' => array('item' => 'contact')));
        $menu->addChild('developers', array('route' => 'foto_join_front_page_homepage', 'routeParameters' => array('item' => 'developers')));
        $menu->addChild('interns', array('route' => 'foto_join_front_page_homepage', 'routeParameters' => array('item' => 'interns')));
        return $menu;

    }

    public function bottomInfoMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');
        $menu->setChildrenAttribute('id', 'info-menu');
        $menu->addChild('support', array('route' => 'foto_join_front_page_homepage', 'routeParameters' => array('item' => 'support')));
        $menu->addChild('terms', array('route' => 'foto_join_front_page_homepage', 'routeParameters' => array('item' => 'terms')));
        $menu->addChild('privacy', array('route' => 'foto_join_front_page_homepage', 'routeParameters' => array('item' => 'privacy')));
        return $menu;
    }

}