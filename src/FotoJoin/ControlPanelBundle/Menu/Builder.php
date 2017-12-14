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
        $menu->addChild('link.gallery', array('route' => 'foto_join_gallery_homepage'))->setExtras(array(
            'icon' => 'picture-o fa-fw',
            'translation_domain' => 'FotoJoinFrontPageBundle',
        ));
        if($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $menu->addChild('link.join', array('route' => 'foto_join_gallery_join'))->setExtras(array(
                'icon' => 'star fa-fw',
                'translation_domain' => 'FotoJoinFrontPageBundle',
            ));
            $menu->addChild('Panel', array('uri' => '#'))->setExtras(array(
                'icon' => 'check-square-o fa-fw',
                'translation_domain' => 'FotoJoinFrontPageBundle',
            ))
            ->setAttributes(array(
                'class' => 'dropdown',
            ))
            ->setExtras(array(
                'dropdown' => true,
            ))
            ->setLinkAttribute('class', 'dropdown-toggle')
            ->setLinkAttribute('data-toggle', 'dropdown')
            ->setLinkAttribute('aria-expanded', 'true')
            ->setChildrenAttribute('class', 'dropdown-menu');

            $menu['Panel']->addChild('status.index', array('route' => 'foto_join_control_panel_homepage'))->setExtras(array(
                'icon' => 'check fa-fw',
                'translation_domain' => 'FotoJoinControlPanelBundle',
            ));
            $menu['Panel']->addChild('profile.show.link', array('route' => 'fos_user_profile_show'))->setExtras(array(
                'icon' => 'user fa-fw',
                'translation_domain' => 'FotoJoinUserBundle',
            ));
            $menu['Panel']->addChild('message.list', array('route' => 'message_index'))->setExtras(array(
                'icon' => 'envelope fa-fw',
                'translation_domain' => 'FotoJoinControlPanelBundle',
            ));
            $menu['Panel']->addChild('album.list', array('route' => 'album_index'))->setExtras(array(
                'icon' => 'book fa-fw',
                'translation_domain' => 'FotoJoinControlPanelBundle',
            ));
            $menu['Panel']->addChild('photography.list', array('route' => 'photography_index'))->setExtras(array(
                'icon' => 'picture-o fa-fw',
                'translation_domain' => 'FotoJoinControlPanelBundle',
            ));
            $menu['Panel']->addChild('security.logout.link', array('route' => 'fos_user_security_logout'))->setExtras(array(
                'icon' => 'sign-out fa-fw',
                'translation_domain' => 'FotoJoinUserBundle',
            ));
        }
        else {
            $menu->addChild('security.login.link', array('route' => 'fos_user_security_login'))->setExtras(array(
                'icon' => 'sign-in fa-fw',
                'translation_domain' => 'FotoJoinUserBundle',
            ));
            $menu->addChild('signup.link', array('route' => 'foto_join_front_page_signup'))->setExtras(array(
                'icon' => 'edit fa-fw',
                'translation_domain' => 'FotoJoinUserBundle'
            ));
        }

        return $menu;

    }

    public function sideMenu(FactoryInterface $factory, array $options)
    {

        $securityContext = $this->container->get('security.context');
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-pills nav-stacked');
        $menu->setChildrenAttribute('id', 'side-menu');

        $menu->addChild('sidemenu.status', array('route' => 'foto_join_control_panel_homepage'))->setExtras(array(
            'icon' => 'check fa-fw',
            'translation_domain' => 'FotoJoinControlPanelBundle',
            'routes' => array('foto_join_control_panel_homepage'),
        ));

        $menu->addChild('sidemenu.profile', array('route' => 'fos_user_profile_show'))->setExtras(array('icon' => 'user fa-fw', 'translation_domain' => 'FotoJoinControlPanelBundle', 'routes' => array(
            'fos_user_profile_show',
            'fos_user_profile_edit',
            'fos_user_change_password',
        )));

        $menu->addChild('sidemenu.message', array('route' => 'message_index'))->setExtras(array(
            'icon' => 'envelope fa-fw',
            'translation_domain' => 'FotoJoinControlPanelBundle',
            'routes' => array('message_index'),
        ));

        $menu->addChild('sidemenu.album', array('route' => 'album_index'))->setExtras(array(
            'icon' => 'book fa-fw',
            'translation_domain' => 'FotoJoinControlPanelBundle',
            'routes' => array('album_index'),
        ));

        $menu->addChild('sidemenu.photography', array('route' => 'photography_index'))->setExtras(array(
            'icon' => 'picture-o fa-fw',
            'translation_domain' => 'FotoJoinControlPanelBundle',
            'routes' => array('photography_index'),
        ));
/*
        $menu->addChild('profile.show.link', array('route' => 'fos_user_profile_show'))->setAttribute('icon', 'user fa-fw')->setAttribute('translation_domain', 'FotoJoinUserBundle');
        $menu->addChild('message.list', array('route' => 'message_index'))->setAttribute('icon', 'envelope fa-fw')->setAttribute('translation_domain', 'FotoJoinControlPanelBundle');
        $menu->addChild('album.list', array('route' => 'album_index'))->setAttribute('icon', 'book fa-fw')->setAttribute('translation_domain', 'FotoJoinControlPanelBundle');
        $menu->addChild('photography.list', array('route' => 'photography_index'))->setAttribute('icon', 'picture-o fa-fw')->setAttribute('translation_domain', 'FotoJoinControlPanelBundle');
*/
        return $menu;

    }

    public function profileTools(FactoryInterface $factory, array $options)
    {

        $profileTools = $factory->createItem('root');
        $profileTools->setChildrenAttribute('class', 'nav nav-pills');
        $profileTools->setChildrenAttribute('id', 'profile-tools');

        $profileTools->addChild('profile.show.link', array('route' => 'fos_user_profile_show'))->setExtras(array('translation_domain' => 'FotoJoinUserBundle', 'routes' => array(
            'fos_user_profile_show',
        )));

        $profileTools->addChild('profile.edit.link', array('route' => 'fos_user_profile_edit'))->setExtras(array('translation_domain' => 'FotoJoinUserBundle', 'routes' => array(
            'fos_user_profile_edit',
        )));

        $profileTools->addChild('change_password.link', array('route' => 'fos_user_change_password'))->setExtras(array('translation_domain' => 'FotoJoinUserBundle', 'routes' => array(
            'fos_user_change_password',
        )));

        return $profileTools;

    }

}