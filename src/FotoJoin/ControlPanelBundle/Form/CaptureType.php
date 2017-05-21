<?php

namespace FotoJoin\ControlPanelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CaptureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('brand', null, array(
                'label' => 'capture.brand',
            ))
            ->add('model', null, array(
                'label' => 'capture.model',
            ))
            ->add('lens', null, array(
                'label' => 'capture.lens',
            ))
            ->add('sensibility', null, array(
                'label' => 'capture.sensibility',
            ))
            ->add('aperture', null, array(
                'label' => 'capture.aperture',
            ))
            ->add('shutter', null, array(
                'label' => 'capture.shutter',
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FotoJoin\ControlPanelBundle\Entity\Capture'
        ));
    }
}
