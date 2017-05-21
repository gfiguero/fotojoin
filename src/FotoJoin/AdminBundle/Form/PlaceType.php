<?php

namespace FotoJoin\AdminBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use FotoJoin\AdminBundle\Entity\City;

class PlaceType extends AbstractType
{
    protected $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country', 'country', array(
                'label' => 'place.country',
                'preferred_choices' => array('CL'),
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
 
/*
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();
            $country = $data->getCountry();
            $form->add('city', 'entity', array(
                'class' => 'FotoJoinAdminBundle:City',
                'query_builder' => function (EntityRepository $er) use ($country) {
                    $qb = $er->createQueryBuilder('city')
                        ->where('city.country = :country')
                        ->setParameter('country', $country);
                    return $qb;
                },
                'choice_label' => 'name',
            ));
        });
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();
            $country = $data->getCountry();
            $form->add('city', 'entity', array(
                'class' => 'FotoJoinAdminBundle:City',
                'query_builder' => function (EntityRepository $er) use ($country) {
                    $qb = $er->createQueryBuilder('city')
                        ->where('city.country = :country')
                        ->setParameter('country', $country);
                    return $qb;
                },
                'choice_label' => 'name',
            ));
        });
*/

    }

    protected function addElements(FormInterface $form, $country = 'CL')
    {
        //$cities = null;
        //if ($country) {
            //$cities = $this->em->getRepository('FotoJoinAdminBundle:City')->findByCountry('CL', array('name' => 'asc'));
        //}

        $form->add('city', 'entity', array(
            'empty_value' => '-- Select a province first --',
            'class' => 'FotoJoinAdminBundle:City',
            'query_builder' => function (EntityRepository $er) use ($country) {
                $qb = $er->createQueryBuilder('city')
                    ->where('city.country = :country')
                    ->setParameter('country', $country);
                return $qb;
            },
            'choice_label' => 'name',
        ));

    }

    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();

        $country = $data['country'];
        $this->addElements($form, $country);
    }


    function onPreSetData(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();

        // We might have an empty account (when we insert a new account, for instance)
        $country = $data->getCountry() ? $data->getCountry() : 'CL';
        var_dump($country);
        $this->addElements($form, $country);
    }


    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FotoJoin\AdminBundle\Entity\Place'
        ));
    }
}
