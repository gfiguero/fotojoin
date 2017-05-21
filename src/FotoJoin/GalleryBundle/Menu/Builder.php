<?php

namespace FotoJoin\GalleryBundle\Menu;

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
        $menu->addChild('user.login', array('route' => 'fos_user_security_login'))->setAttribute('icon', 'sign-in fa-fw');
        $menu->addChild('user.logout', array('route' => 'fos_user_security_logout'))->setAttribute('icon', 'sign-out fa-fw');
        $menu->addChild('user.register', array('route' => 'fos_user_security_'))->setAttribute('icon', 'user fa-fw');
        $menu->addChild('user.profile', array('route' => 'fos_user_security_login'))->setAttribute('icon', 'group fa-fw');

        return $menu;

    }

}