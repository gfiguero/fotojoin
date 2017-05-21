<?php

namespace FotoJoin\GalleryBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AddOrderFieldSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(FormEvents::PRE_SET_DATA => 'preSetData');
    }

    private function addOrderForm($form)
    {
        $form->add('order', 'gallery_order', array(
            'label' => false,
            'translation_domain' => 'FotoJoinGalleryBundle',
        ));
    }

    public function preSetData(FormEvent $event)
    {
        $gallery = $event->getData();
        $form = $event->getForm();
        $this->addOrderForm($form);
    }
}