<?php

namespace FotoJoin\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Util\LegacyFormHelper;

class ResettingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'options' => array(
                    'translation_domain' => 'FotoJoinUserBundle'
                ),
                'first_options' => array(
                    'label' => false,
                    'attr' => array(
                        'placeholder' => 'form.new_password',
                        'input_group' => array(
                            'prepend' => '.icon-lock+fw',
                        ),
                    ),
                ),
                'second_options' => array(
                    'label' => false,
                    'attr' => array(
                        'placeholder' => 'form.new_password_confirmation',
                        'input_group' => array(
                            'prepend' => '.icon-lock+fw',
                        ),
                    ),
                ),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
        ;

    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ResettingFormType';
    }

    public function getBlockPrefix()
    {
        return 'fotojoin_user_resetting';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}