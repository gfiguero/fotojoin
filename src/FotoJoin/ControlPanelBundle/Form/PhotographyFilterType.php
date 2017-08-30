<?php

namespace FotoJoin\ControlPanelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class PhotographyFilterType extends AbstractType
{

    private $security_context;

    public function __construct($security_context)
    {
        $this->security_context = $security_context;
    }

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
                'query_builder' => function (EntityRepository $er) use ($options) {
                    return $er->createQueryBuilder('a')
                        ->where('a.user = :user')
                        ->setParameter('user', $options['user'])
                    ;
                },
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'user'       => $this->security_context->getToken()->getUser(),
        ));
    }

}
