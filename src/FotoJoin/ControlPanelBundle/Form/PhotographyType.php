<?php

namespace FotoJoin\ControlPanelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use FotoJoin\ControlPanelBundle\Form\EntityHiddenType;
use FotoJoin\ControlPanelBundle\Form\PhotographyFileType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use FotoJoin\ControlPanelBundle\Form\EventListener\PhotographyListener;

class PhotographyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', 'entity_hidden', array(
                'class' => 'FotoJoinUserBundle:Author',
            ))
            ->add('file', 'photography_file', array(
                'label' => 'photography.file.label',
                'translation_domain' => 'FotoJoinControlPanelBundle',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
                'required' => false,
            ))
            ->add('categories', 'entity', array(
                'label' => 'photography.categories',
                'class' => 'FotoJoinAdminBundle:Category',
                'multiple' => true,
                'required' => false,
                'attr' => array('label_col' => 3, 'widget_col' => 9, 'class' => 'photography_categories' ),
                'translation_domain' => 'FotoJoinControlPanelBundle',
            ))
            ->add('album', 'entity', array(
                'label' => 'photography.album',
                'class' => 'FotoJoinControlPanelBundle:Album',
                'choice_label' => 'name',
                'required' => false,
                'attr' => array('label_col' => 3, 'widget_col' => 9, 'class' => 'photography_album' ),
                'translation_domain' => 'FotoJoinControlPanelBundle',
                'placeholder' => 'Ninguno',
            ))
/**********************************************************/
            ->add('MakeModel', null, array(
                'label' => 'photography.capture.MakeModel',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
                'translation_domain' => 'FotoJoinControlPanelBundle',
            ))
            ->add('DateTimeOriginal', null, array(
                'label' => 'photography.capture.DateTimeOriginal',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
                'translation_domain' => 'FotoJoinControlPanelBundle',
            ))
            ->add('ExposureTime', null, array(
                'label' => 'photography.capture.ExposureTime',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
                'translation_domain' => 'FotoJoinControlPanelBundle',
            ))
            ->add('FocalLength', null, array(
                'label' => 'photography.capture.FocalLength',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
                'translation_domain' => 'FotoJoinControlPanelBundle',
            ))
            ->add('FNumber', null, array(
                'label' => 'photography.capture.FNumber',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
                'translation_domain' => 'FotoJoinControlPanelBundle',
            ))
            ->add('ISOSpeedRatings', null, array(
                'label' => 'photography.capture.ISOSpeedRatings',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
                'translation_domain' => 'FotoJoinControlPanelBundle',
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FotoJoin\ControlPanelBundle\Entity\Photography'
        ));
    }
}
