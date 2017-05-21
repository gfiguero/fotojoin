<?php

namespace FotoJoin\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;

class CityType extends AbstractType
{
    protected $em;
    public function __construct(Doctrine $doctrine)
    {
        $this->em = $doctrine->getManager();
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FotoJoin\AdminBundle\Entity\City'
        ));
    }

    protected function addElements(FormInterface $form, $country = null)
    {
        $cities = array();
        if ($country) {
            $er = $this->em->getRepository('FotoJoinAdminBundle:City');
            $cities = $er->findByCountry($country, array('name' => 'asc'));
        }
        $form->add('city', 'choice', array(
            'empty_value' => '-- Select a country first --',
            'mapped' => false,
            'choices' => $cities,
            'label' => false,
            'attr' => array('label_col' => 0, 'widget_col' => 12 ),
        ));
    }
    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();
        $country = 'CL';
        $this->addElements($form, $country);
    }
    function onPreSetData(FormEvent $event) {
        $country = $event->getForm();
        $form = $event->getForm();
//        var_dump($form->get('country'));
        $data = $event->getData();
//        $country = $data->getCity() ? $data->getCity()->getCountry() : null;
        $country = 'CL';
        $this->addElements($form, $country);
    }



    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
/*
        $builder->add('city', 'choice', array(
            'required' => $options['required'],
            'label'    => $options['label'],
        ));
        // add delete only if there is a file
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
//            $object = $form->getParent()->getData();
        });
*/
    }
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['object'] = $form->getParent()->getData();
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'city';
    }
    // BC for SF < 2.8
    public function getName()
    {
        return $this->getBlockPrefix();
    }
    // ugly workaround for SF < 2.8 compatibility
    protected function getFieldType($shortType)
    {
        if (method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')) {
            return sprintf('Symfony\Component\Form\Extension\Core\Type\%sType', ucfirst($shortType));
        }
        return $shortType;
    }
}