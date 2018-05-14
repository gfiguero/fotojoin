<?php

namespace FotoJoin\FrontPageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'required' => true,
                'label' => false,
                'translation_domain' => 'FotoJoinFrontPageBundle',
                'attr' => array(
                    'placeholder' => 'contact.form.name',
                    'input_group' => array(
                        'prepend' => '.icon-user+fw',
                    ),
                ),
            ))
            ->add('email', 'email', array(
                'required' => true,
                'label' => false,
                'translation_domain' => 'FotoJoinFrontPageBundle',
                'attr' => array(
                    'placeholder' => 'contact.form.email',
                    'input_group' => array(
                        'prepend' => '.icon-envelope+fw',
                    ),
                ),
            ))
            ->add('tag', 'contact_reason', array(
                'required' => true,
                'label' => false,
                'translation_domain' => 'FotoJoinFrontPageBundle',
                'attr' => array(
                    'input_group' => array(
                        'prepend' => '.icon-tag+fw',
                    ),
                ),
            ))
            ->add('message', 'textarea', array(
                'required' => true,
                'label' => false,
                'translation_domain' => 'FotoJoinFrontPageBundle',
                'attr' => array(
                    'placeholder' => 'contact.form.message',
                    'input_group' => array(
                        'prepend' => '.icon-comment+fw',
                    ),
                ),
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FotoJoin\AdminBundle\Entity\Contact'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fotojoin_adminbundle_contact';
    }

}
