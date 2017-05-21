<?php

namespace FotoJoin\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country', 'country', array(
                'label' => 'city.country',
                'preferred_choices' => array('CL'),
                'translation_domain' => 'FotoJoinAdminBundle',
                'attr' => array('label_col' => 4, 'widget_col' => 8 ),
            ))
            ->add('name', null, array(
                'label' => 'city.name',
                'translation_domain' => 'FotoJoinAdminBundle',
                'attr' => array('label_col' => 4, 'widget_col' => 8 ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FotoJoin\AdminBundle\Entity\City'
        ));
    }
}
