<?php

namespace FotoJoin\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GalleryOrderType extends AbstractType
{
    private $galleryOrderChoices;

    public function __construct(array $galleryOrderChoices)
    {
        $this->galleryOrderChoices = $galleryOrderChoices;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->galleryOrderChoices,
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }

    public function getBlockPrefix()
    {
        return 'gallery_order';
    }

}