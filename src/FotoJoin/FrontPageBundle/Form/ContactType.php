<?php

namespace FotoJoin\FrontPageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', 'text', array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Nombre',
                    'input_group' => array(
                        'prepend' => '.icon-user+fw',
                    ),
                ),
            ))
            ->add('email', 'email', array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Email',
                    'input_group' => array(
                        'prepend' => '.icon-envelope+fw',
                    ),
                ),
            ))
            ->add('asunto', 'contact_reason', array(
                'label' => false,
                'attr' => array(
                    'input_group' => array(
                        'prepend' => '.icon-tag+fw',
                    ),
                ),
            ))
            ->add('mensaje', 'textarea', array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Mensaje',
                    'input_group' => array(
                        'prepend' => '.icon-comment+fw',
                    ),
                ),
            ))
        ;
    }
    
}
