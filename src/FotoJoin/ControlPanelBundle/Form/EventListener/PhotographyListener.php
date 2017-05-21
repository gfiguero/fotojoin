<?php

namespace FotoJoin\ControlPanelBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PhotographyListener implements EventSubscriberInterface {

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'onPreSetData',
            FormEvents::PRE_SUBMIT => 'onPreSubmit',
        );
    }

    public function onPreSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (!$data) {
            return;
        }

        $exif = exif_read_data($form->get('file'));
        $form->add('exif', 'text', array(
            'data' => $exif,
        ));

        // Check whether the user has chosen to display his email or not.
        // If the data was submitted previously, the additional value that
        // is included in the request variables needs to be removed.
        /*
        if (true === $data['exif']) {
            $form->add('exif', 'text');
        } else {
            unset($data['exif']);
            $event->setData($data);
        }
        */
    }
    public function onPreSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        $form->add('exif', 'text', array(
            'required' => false,
        ));
    }
}