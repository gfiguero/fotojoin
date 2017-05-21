<?php

namespace FotoJoin\ControlPanelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhotographyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('filename')->add('value')->add('published')->add('MakeModel')->add('DateTimeOriginal')->add('ExposureTime')->add('FocalLength')->add('FNumber')->add('ISOSpeedRatings')->add('createdAt')->add('updatedAt')->add('deletedAt')->add('user')->add('album')->add('categories');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FotoJoin\ControlPanelBundle\Entity\Photography'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fotojoin_controlpanelbundle_photography';
    }


}
