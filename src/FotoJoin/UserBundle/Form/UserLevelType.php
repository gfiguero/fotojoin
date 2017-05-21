<?php

namespace FotoJoin\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserLevelType extends AbstractType
{
    private $userLevelChoices;

    public function __construct(array $userLevelChoices)
    {
        $this->userLevelChoices = $userLevelChoices;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->userLevelChoices,
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
        return 'user_level';
    }

}