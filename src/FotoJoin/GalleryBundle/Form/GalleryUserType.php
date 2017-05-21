<?php

namespace FotoJoin\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManager;

class GalleryUserType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->galleryUserChoices,
            'label' => false,
            'translation_domain' => 'FotoJoinGalleryBundle',
            'class' => 'FotoJoinUserBundle:User',
            'multiple' => true,
            'required' => false,
            'cities' => null,
            'categories' => null,
        ));
    }

    public function getParent()
    {
        return 'entity';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }

    public function getBlockPrefix()
    {
        return 'gallery_user';
    }

}