<?php

namespace FotoJoin\ControlPanelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FotoJoin\ControlPanelBundle\Form\EntityHiddenType;
use FotoJoin\ControlPanelBundle\Form\PhotographyCollectionType;
use Vich\UploaderBundle\Form\DataTransformer\FileTransformer;

class NewAlbumType extends AbstractType
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
