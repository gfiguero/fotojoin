<?php

namespace FotoJoin\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

use FotoJoin\UserBundle\Form\AuthorType;
use FotoJoin\UserBundle\Form\ProfilePhotoType;
use FotoJoin\UserBundle\Form\CityType;

class ProfileType extends AbstractType
{
    private $authorizationChecker;

    public function __construct(AuthorizationChecker $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
            ->remove('name')
            ->remove('email')
            ->remove('current_password')
            ->remove('username')

            ->add('name', null, array(
                'label' => 'form.name',
                'translation_domain' => 'FotoJoinUserBundle',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
            ))
            ->add('birthdate', 'birthday', array(
                'label' => 'form.birthdate',
                'translation_domain' => 'FotoJoinUserBundle',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
                'placeholder' => array(
                    'year' => 'Año',
                    'month' => 'Mes',
                    'day' => 'Día',
                ),
                'required' => false,
            ))
            ->add('profilephoto', 'profile_photo', array(
                'label' => 'form.profilephoto.type',
                'translation_domain' => 'FotoJoinUserBundle',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
                'required' => false,
            ))
            ->add('publiccontact', null, array(
                'label' => 'form.publiccontact',
                'translation_domain' => 'FotoJoinUserBundle',
                'attr' => array('label_col' => 3, 'widget_col' => 9, 'align_with_widget' => true ),
                'required' => false,
            ))
            ->add('city1', 'entity', array(
                'required' => false,
                'placeholder' => 'form.city.select',
                'empty_value' => null,
                'class' => 'FotoJoinAdminBundle:City',
                'label' => 'form.city.1',
                'translation_domain' => 'FotoJoinUserBundle',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
            ))
            ->add('city2', 'entity', array(
                'required' => false,
                'placeholder' => 'form.city.select',
                'empty_value' => null,
                'class' => 'FotoJoinAdminBundle:City',
                'label' => 'form.city.2',
                'translation_domain' => 'FotoJoinUserBundle',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
            ))
            ->add('city3', 'entity', array(
                'required' => false,
                'placeholder' => 'form.city.select',
                'empty_value' => null,
                'class' => 'FotoJoinAdminBundle:City',
                'label' => 'form.city.3',
                'translation_domain' => 'FotoJoinUserBundle',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
            ))
        ;

        if($this->authorizationChecker->isGranted('ROLE_AUTHOR')) $builder
            ->add('level', 'user_level', array(
                'label' => 'form.level.type',
                'translation_domain' => 'FotoJoinUserBundle',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
                'required' => false,
                'placeholder' => 'Seleccione su nivel',
            ))
            ->add('exigency', 'user_exigency', array(
                'label' => 'form.exigency.type',
                'translation_domain' => 'FotoJoinUserBundle',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
                'required' => false,
                'placeholder' => 'Seleccione su nivel de exigencia',
            ))
            ->add('description', 'textarea', array(
                'label' => 'form.description',
                'translation_domain' => 'FotoJoinUserBundle',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
                'required' => false,
//                'placeholder' => 'Describa su experiencia como fotógrafo',
            ))
            ->add('facebookshare', null, array(
                'label' => 'form.facebookshare',
                'translation_domain' => 'FotoJoinUserBundle',
                'attr' => array('label_col' => 3, 'widget_col' => 9, 'align_with_widget' => true ),
                'required' => false,
            ))
        ;
//        if($options['isAuthor']) $builder->add('author', new AuthorType($builder));
//            ->add('cities', 'Symfony\Component\Form\Extension\Core\Type\CollectionType', array(
//                'mapped' => false,
//                'entry_type' => 'email',
//                'entry_type' => 'FotoJoin\UserBundle\Form\CityType',
//                'prototype' => true,
//            ))
/*
            ->add('cities', 'bootstrap_collection', array(
                'allow_add'          => true,
                'allow_delete'       => true,
                'add_button_text'    => 'form.city.add',
                'delete_button_text' => 'form.city.delete',
                'sub_widget_col'     => 9,
                'button_col'         => 3,
                'entry_type' => 'FotoJoin\UserBundle\Form\CityType',
                'label' => 'form.city.type',
                'translation_domain' => 'FotoJoinUserBundle',
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
            ))
*/
/*
            ->add('profilephoto', 'Vich\UploaderBundle\Form\Type\VichImageType', array(
                'label' => 'form.profilephoto',
                'data_class' => null,
                'required' => false,
                'allow_delete'  => true, // not mandatory, default is true
                'download_link' => true, // not mandatory, default is true
                'attr' => array('label_col' => 3, 'widget_col' => 9 ),
            ))
            ->add('profilephoto', 'vich_image', array(
                'translation_domain' => 'FotoJoinUserBundle',
                'required'      => false,
            ))
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array(
                'label' => 'form.email',
                'translation_domain' => 'FotoJoinUserBundle',
            ))
            ->add('current_password', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'), array(
                'label' => 'form.current_password',
                'translation_domain' => 'FotoJoinUserBundle',
                'mapped' => false,
                'constraints' => new UserPassword(),
            ))
*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'isAuthor' => false,
        ));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'fotojoin_user_profile';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
