<?php

namespace FotoJoin\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use FotoJoin\GalleryBundle\Form\EventListener\AddCitiesFieldSubscriber;
use FotoJoin\GalleryBundle\Form\EventListener\AddCategoriesFieldSubscriber;
use FotoJoin\GalleryBundle\Form\EventListener\AddUsersFieldSubscriber;
use FotoJoin\GalleryBundle\Form\EventListener\AddOrderFieldSubscriber;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;

class GalleryType extends AbstractType
{
    /** @var \Doctrine\ORM\EntityManager */
    private $em;

    /**
     * Constructor
     * 
     * @param Doctrine $doctrine
     */
    public function __construct(Doctrine $doctrine)
    {
        $this->em = $doctrine->getManager();
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventSubscriber(new AddCitiesFieldSubscriber())
            ->addEventSubscriber(new AddCategoriesFieldSubscriber())
            ->addEventSubscriber(new AddUsersFieldSubscriber($this->em))
            ->addEventSubscriber(new AddOrderFieldSubscriber())
        ;
    }
    
}
