<?php

namespace FotoJoin\ControlPanelBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function topMenu(FactoryInterface $factory, array $options)
    {
        $securityContext = $this->container->get('security.context');
//        $user = $securityContext->getToken()->getUser();
//        $roles = array();
//        if($user instanceof Object) $roles = $user->getRoles();
//        foreach ($user->getRoles() as $key => $value) { echo $value; }
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');
        $menu->setChildrenAttribute('id', 'top-menu');
        $menu->addChild('link.gallery', array('route' => 'foto_join_gallery_homepage'))->setAttribute('icon', 'picture-o fa-fw')->setAttribute('translation_domain', 'FotoJoinFrontPageBundle');
        if($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $menu->addChild('link.join', array('route' => 'foto_join_gallery_join'))->setAttribute('icon', 'star fa-fw')->setAttribute('translation_domain', 'FotoJoinFrontPageBundle');
            $menu->addChild('Panel')
                ->setAttribute('icon', 'check-square-o fa-fw')
                ->setAttribute('translation_domain', 'FotoJoinFrontPageBundle')
                ->setLabelAttribute('class', 'dropdown-toggle')
                ->setLabelAttribute('data-toggle', 'dropdown')
                ->setLabelAttribute('role', 'button')
                ->setLabelAttribute('aria-haspopup', 'true')
                ->setLabelAttribute('aria-expanded', 'false')
                ->setChildrenAttribute('class', 'dropdown-menu');

            $menu['Panel']->addChild('status.index', array('route' => 'foto_join_control_panel_homepage'))->setAttribute('icon', 'check fa-fw')->setAttribute('translation_domain', 'FotoJoinControlPanelBundle');
            $menu['Panel']->addChild('profile.show.link', array('route' => 'fos_user_profile_show'))->setAttribute('icon', 'user fa-fw')->setAttribute('translation_domain', 'FotoJoinUserBundle');
            $menu['Panel']->addChild('message.list', array('route' => 'message_index'))->setAttribute('icon', 'envelope fa-fw')->setAttribute('translation_domain', 'FotoJoinControlPanelBundle');

            if($securityContext->isGranted('ROLE_AUTHOR')) $menu['Panel']->addChild('photography.list', array('route' => 'photography_index'))->setAttribute('icon', 'picture-o fa-fw')->setAttribute('translation_domain', 'FotoJoinControlPanelBundle');
            if($securityContext->isGranted('ROLE_AUTHOR')) $menu['Panel']->addChild('album.list', array('route' => 'album_index'))->setAttribute('icon', 'book fa-fw')->setAttribute('translation_domain', 'FotoJoinControlPanelBundle');

            $menu['Panel']->addChild('security.logout.link', array('route' => 'fos_user_security_logout'))->setAttribute('icon', 'sign-out fa-fw')->setAttribute('translation_domain', 'FotoJoinUserBundle');
        }
        else {
            $menu->addChild('security.login.link', array('route' => 'fos_user_security_login'))
                ->setAttribute('icon', 'sign-in fa-fw')
                ->setAttribute('translation_domain', 'FotoJoinUserBundle');
//            $menu->addChild('registration.link', array('route' => 'fos_user_registration_register'))
//                ->setAttribute('icon', 'edit fa-fw')
//                ->setAttribute('translation_domain', 'FotoJoinUserBundle');
            $menu->addChild('signup.link', array('route' => 'foto_join_front_page_signup'))
                ->setAttribute('icon', 'edit fa-fw')
                ->setAttribute('translation_domain', 'FotoJoinUserBundle');
        }


//        $menu->addChild('home', array('route' => 'member_index'))->setAttribute('icon', 'home fa-fw');
//        $menu->addChild('user_profile', array('route' => 'member_index'))->setAttribute('icon', 'user fa-fw');
//        $menu->addChild('user_index', array('route' => 'member_index'))->setAttribute('icon', 'group fa-fw');
//        $menu->addChild('logout', array('route' => 'member_index'))->setAttribute('icon', 'sign-out fa-fw');

        return $menu;

    }

    public function sideMenu(FactoryInterface $factory, array $options)
    {

        $securityContext = $this->container->get('security.context');
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');
        $menu->setChildrenAttribute('id', 'side-menu');
//        $menu->addChild('panel.link', array('route' => 'foto_join_control_panel_homepage'))->setAttribute('icon', 'square-o fa-fw')->setAttribute('translation_domain', 'FotoJoinControlPanelBundle');
        $menu->addChild('status.index', array('route' => 'foto_join_control_panel_homepage'))->setAttribute('icon', 'check fa-fw')->setAttribute('translation_domain', 'FotoJoinControlPanelBundle');
        $menu->addChild('profile.show.link', array('route' => 'fos_user_profile_show'))->setAttribute('icon', 'user fa-fw')->setAttribute('translation_domain', 'FotoJoinUserBundle');
        $menu->addChild('message.list', array('route' => 'message_index'))->setAttribute('icon', 'envelope fa-fw')->setAttribute('translation_domain', 'FotoJoinControlPanelBundle');
        if($securityContext->isGranted('ROLE_AUTHOR')) {
            $menu->addChild('album.list', array('route' => 'album_index'))->setAttribute('icon', 'book fa-fw')->setAttribute('translation_domain', 'FotoJoinControlPanelBundle');
            $menu->addChild('photography.list', array('route' => 'photography_index'))->setAttribute('icon', 'picture-o fa-fw')->setAttribute('translation_domain', 'FotoJoinControlPanelBundle');
        }
//        $menu->addChild('photo.index', array('route' => 'member_index'))->setAttribute('icon', 'photo fa-fw');
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

}