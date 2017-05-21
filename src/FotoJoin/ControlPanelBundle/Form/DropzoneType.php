<?php

namespace FotoJoin\ControlPanelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FotoJoin\ControlPanelBundle\Form\EntityHiddenType;
use FotoJoin\ControlPanelBundle\Form\PhotographyCollectionType;
use Vich\UploaderBundle\Form\DataTransformer\FileTransformer;

class DropzoneType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'photography_collection', array(
                'label' => false,
                'required' => false,
                'mapped' => false,
            ))
        ;
    }
}
