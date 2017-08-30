<?php

namespace FotoJoin\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppraisementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('value', null, array(
                'label' => 'appraisement.form.value',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('score', null, array(
                'label' => 'appraisement.form.score',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('delay', null, array(
                'label' => 'appraisement.form.delay',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('ip', null, array(
                'label' => 'appraisement.form.ip',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('photography', null, array(
                'label' => 'appraisement.form.photography',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('user', null, array(
                'label' => 'appraisement.form.user',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FotoJoin\GalleryBundle\Entity\Appraisement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fotojoin_gallerybundle_appraisement';
    }


}
