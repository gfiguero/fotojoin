<?php

namespace FotoJoin\ControlPanelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Doctrine\ORM\EntityRepository;

class PhotographyFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
            ->add('album', 'entity', array(
                'empty_value' => 'Todos los álbumes',
                'empty_data' => null,
                'label' => null,
                'class' => 'FotoJoinControlPanelBundle:Album',
                'choice_label' => 'name',
                'required' => false,
                'attr' => array('class' => 'photography_filter'),
            ))
        ;
    }

    public function getBlockPrefix()
    {
        return 'photography_filter';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }

}
