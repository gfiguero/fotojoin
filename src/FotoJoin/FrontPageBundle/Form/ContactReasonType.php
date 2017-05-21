<?php

namespace FotoJoin\FrontPageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactReasonType extends AbstractType
{
    private $contactReasonChoices;

    public function __construct(array $contactReasonChoices)
    {
        $this->contactReasonChoices = $contactReasonChoices;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'placeholder' => 'Seleccione un asunto',
            'choices' => $this->contactReasonChoices,
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
        return 'contact_reason';
    }

}