<?php

namespace FotoJoin\GalleryBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityRepository;

class AddCategoriesFieldSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT   => 'preSubmit'
        );
    }

    private function addCategoriesForm($form, $cities = null)
    {
        $form->add('categories', 'entity', array(
            'label'              => false,
            'translation_domain' => 'FotoJoinGalleryBundle',
            'class'              => 'FotoJoinAdminBundle:Category',
            'multiple'           => true,
            'required'           => false,
            'query_builder'      => function (EntityRepository $er) use ($cities) {
                return $er->getCategoriesByCities($cities);
            }
        ));
    }

    public function preSetData(FormEvent $event)
    {
        $gallery = $event->getData();
        $form    = $event->getForm();
        $cities  = $gallery->getCities();
        $this->addCategoriesForm($form, $cities);
    }

    public function preSubmit(FormEvent $event)
    {
        $gallery = $event->getData();
        $form    = $event->getForm();
        $cities  = array_key_exists('cities', $gallery) ? $gallery['cities'] : array();
        $this->addCategoriesForm($form, $cities);
    }
}