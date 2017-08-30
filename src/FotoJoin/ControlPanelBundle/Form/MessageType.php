<?php

namespace FotoJoin\ControlPanelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', null, array(
                'label' => 'message.content',
                'translation_domain' => 'FotoJoinControlPanelBundle',
                'attr' => array('label_col' => 4, 'widget_col' => 8 ),
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FotoJoin\ControlPanelBundle\Entity\Message'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fotojoin_controlpanelbundle_message';
    }


}
