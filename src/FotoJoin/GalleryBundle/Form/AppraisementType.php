<?php

namespace FotoJoin\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppraisementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', 'hidden')
            ->add('delay', 'hidden')
            ->add('ip', 'hidden')
            ->add('photography', 'entity_hidden', array(
                'class' => 'FotoJoinControlPanelBundle:Photography',
            ))
            ->add('user', 'entity_hidden', array(
                'class' => 'FotoJoinUserBundle:User',
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FotoJoin\GalleryBundle\Entity\Appraisement'
        ));
    }
}
