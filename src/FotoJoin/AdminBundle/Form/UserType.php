<?php

namespace FotoJoin\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('plan', null, array(
                'required' => true,
                'label' => 'user.form.plan',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('level', 'user_level', array(
                'required' => true,
                'label' => 'user.form.level',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('email', null, array(
                'required' => true,
                'label' => 'user.form.email',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('password', null, array(
                'required' => true,
                'label' => 'user.form.password',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('name', null, array(
                'required' => true,
                'label' => 'user.form.name',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('description', null, array(
                'label' => 'user.form.description',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('birthdate', 'birthday', array(
                'label' => 'user.form.birthdate',
                'translation_domain' => 'FotoJoinAdminBundle',
                'attr' => array('label_col' => 4, 'widget_col' => 8 ),
                'placeholder' => ['year' => 'Año', 'month' => 'Mes', 'day' => 'Día'],
                'required' => false,
            ))
            ->add('profilephoto', 'profile_photo', array(
                'label' => 'user.form.profilephoto',
                'translation_domain' => 'FotoJoinAdminBundle',
                'attr' => array('label_col' => 4, 'widget_col' => 8 ),
                'required' => false,
            ))
//            ->add('publiccontact', null, array(
//                'label' => 'user.form.publiccontact',
//                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
//                'translation_domain' => 'FotoJoinAdminBundle',
//            )) 
            ->add('exigency', 'user_exigency', array(
                'label' => 'user.form.exigency',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('facebookid', null, array(
                'label' => 'user.form.facebookid',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('facebookaccesstoken', null, array(
                'label' => 'user.form.facebookaccesstoken',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
//            ->add('facebookshare', null, array(
//                'label' => 'user.form.facebookshare',
//                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
//                'translation_domain' => 'FotoJoinAdminBundle',
//            )) 
            ->add('googleid', null, array(
                'label' => 'user.form.googleid',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('googleaccesstoken', null, array(
                'label' => 'user.form.googleaccesstoken',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('twitterid', null, array(
                'label' => 'user.form.twitterid',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
            ->add('twitteraccesstoken', null, array(
                'label' => 'user.form.twitteraccesstoken',
                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
                'translation_domain' => 'FotoJoinAdminBundle',
            )) 
//            ->add('city1', null, array(
//                'label' => 'user.form.city1',
//                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
//                'translation_domain' => 'FotoJoinAdminBundle',
//            )) 
//            ->add('city2', null, array(
//                'label' => 'user.form.city2',
//                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
//                'translation_domain' => 'FotoJoinAdminBundle',
//            )) 
//            ->add('city3', null, array(
//                'label' => 'user.form.city3',
//                'attr'  => array( 'label_col' => 4, 'widget_col' => 8 ),
//                'translation_domain' => 'FotoJoinAdminBundle',
//            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FotoJoin\UserBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fotojoin_userbundle_user';
    }


}
