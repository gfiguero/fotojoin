<?php

namespace FotoJoin\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use FotoJoin\UserBundle\Form\AuthorLevelType;

class AuthorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('level', 'author_level', array(
                'label' => 'author.level.type',
                'translation_domain' => 'FotoJoinUserBundle',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
                'required' => false,
            ))
            ->add('exigency', 'author_exigency', array(
                'label' => 'author.exigency.type',
                'translation_domain' => 'FotoJoinUserBundle',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
                'required' => false,
            ))
            ->add('description', 'textarea', array(
                'label' => 'author.description',
                'translation_domain' => 'FotoJoinUserBundle',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
                'required' => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FotoJoin\UserBundle\Entity\Author'
        ));
    }
}
