<?php

namespace FotoJoin\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserExigencyType extends AbstractType
{
    private $userExigencyChoices;

    public function __construct(array $userExigencyChoices)
    {
        $this->userExigencyChoices = $userExigencyChoices;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->userExigencyChoices,
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
        return 'user_exigency';
    }

}