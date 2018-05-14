<?php

namespace FotoJoin\AdminBundle\Form;

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
        $builder
//            ->add('filename', null, array(
//                'label' => 'photography.form.filename',
//                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
//                'translation_domain' => 'FotoJoinAdminBundle',
//            )) 
//            ->add('value', null, array(
//                'label' => 'photography.form.value',
//                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
//                'translation_domain' => 'FotoJoinAdminBundle',
//            )) 
            ->add('MakeModel', null, array(
                'label' => 'photography.form.MakeModel',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('DateTimeOriginal', null, array(
                'label' => 'photography.form.DateTimeOriginal',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('ExposureTime', null, array(
                'label' => 'photography.form.ExposureTime',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('FocalLength', null, array(
                'label' => 'photography.form.FocalLength',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('FNumber', null, array(
                'label' => 'photography.form.FNumber',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('ISOSpeedRatings', null, array(
                'label' => 'photography.form.ISOSpeedRatings',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('user', null, array(
                'label' => 'photography.form.user',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('album', null, array(
                'label' => 'photography.form.album',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            ))
            ->add('published', null, array(
                'label' => 'photography.form.published',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
//            ->add('categories', null, array(
//                'label' => 'photography.form.categories',
//                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
//                'translation_domain' => 'FotoJoinAdminBundle',
//            ))
        ;
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
