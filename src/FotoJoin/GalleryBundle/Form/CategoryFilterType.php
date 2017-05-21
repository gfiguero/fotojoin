<?php

namespace FotoJoin\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\Constraints\NotBlank;

class CategoryFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
            ->add('category', 'entity', array(
                'label' => false,
                'required' => false,
                'multiple' => false,
                'class' => 'FotoJoinAdminBundle:Category',
                'placeholder' => 'Sin restricción de Categoría',
                'empty_data' => null,
                'choice_label' => 'name',
                'attr' => array('class' => 'category_filter'),
            ))
        ;
    }

    public function getBlockPrefix()
    {
        return 'category_filter';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }

}
