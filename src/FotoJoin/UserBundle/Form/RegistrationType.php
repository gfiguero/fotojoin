<?php

namespace FotoJoin\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\UserBundle\Util\LegacyFormHelper;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('username')
            ->remove('name')
            ->remove('email')
            ->remove('plainPassword')
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array(
                'label' => false,
                'translation_domain' => 'FotoJoinUserBundle',
                'attr' => array(
                    'placeholder' => 'user.form.email',
                    'label_col' => 4,
                    'widget_col' => 8,
                    'input_group' => array(
                        'prepend' => '.icon-envelope+fw',
                    ),
                ),
            ))
            ->add('name', null, array(
                'label' => false,
                'translation_domain' => 'FotoJoinUserBundle',
                'attr' => array(
                    'placeholder' => 'user.form.name',
                    'label_col' => 4,
                    'widget_col' => 8,
                    'input_group' => array(
                        'prepend' => '.icon-comment+fw',
                    ),
                ),
            ))
            ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'options' => array('translation_domain' => 'FotoJoinUserBundle'),
                'first_options' => array(
                    'label' => false,
                    'attr' => array(
                        'placeholder' => 'user.form.password',
                        'input_group' => array(
                            'prepend' => '.icon-lock+fw',
                        ),
                    ),
                ),
                'second_options' => array(
                    'label' => false,
                    'attr' => array(
                        'placeholder' => 'user.form.password_confirmation',
                        'input_group' => array(
                            'prepend' => '.icon-lock+fw',
                        ),
                    ),
                ),
                'invalid_message' => 'user.password.mismatch',
                'attr' => array(
                    'widget_col' => 12,
                ),
            ))
            ->add('termsAccepted', 'checkbox', array(
                'label' => 'user.form.termsAccepted',
                'translation_domain' => 'FotoJoinUserBundle',
                'mapped' => false,
                'constraints' => new IsTrue(),
                'attr' => array('align_with_widget' => true, 'widget_col' => 12, 'label_col' => 0),
            ))
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'fotojoin_user_registration';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}