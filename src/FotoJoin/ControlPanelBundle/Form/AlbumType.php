<?php

namespace FotoJoin\ControlPanelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FotoJoin\ControlPanelBundle\Form\EntityHiddenType;
use FotoJoin\ControlPanelBundle\Form\PhotographyCollectionType;
use Vich\UploaderBundle\Form\DataTransformer\FileTransformer;

class AlbumType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'album.form.name',
                'translation_domain' => 'FotoJoinControlPanelBundle',
                'attr' => array('label_col' => 4, 'widget_col' => 8 ),
            ))
            ->add('user', 'entity_hidden', array(
                'class' => 'FotoJoin\UserBundle\Entity\User'
            ))
/*
            ->add('photographies', 'bootstrap_collection', array(
                'label' => false,
                'attr'  => array( 'label_col' => 0, 'widget_col' => 12 ),
                'translation_domain' => 'FotoJoinControlPanelBundle',
                'entry_type' => 'FotoJoin\ControlPanelBundle\Form\PhotographyAlbumType',
                'allow_delete' => true,
                'by_reference' => false,
            ))
*/
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FotoJoin\ControlPanelBundle\Entity\Album'
        ));
    }
}
