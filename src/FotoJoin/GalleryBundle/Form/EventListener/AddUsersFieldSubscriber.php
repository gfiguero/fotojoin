<?php

namespace FotoJoin\GalleryBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use FotoJoin\UserBundle\Entity\User;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;

class AddUsersFieldSubscriber implements EventSubscriberInterface
{
    /** @var \Doctrine\ORM\EntityManager */
    private $em;

    /**
     * Constructor
     * 
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    public static function getSubscribedEvents()
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit'
        );
    }

    private function addUsersForm($form, $cities = null, $categories = null)
    {
        $users = $this->getUsersByCitiesCategories($cities, $categories);
        $form->add('users', 'entity', array(
            'label' => false,
            'translation_domain' => 'FotoJoinGalleryBundle',
            'class' => 'FotoJoinUserBundle:User',
            'multiple' => true,
            'required' => false,
            'choices' => $users,
            'choice_label' => function($user) { 
                return $user->getName() . ' (' . $user->getAverage() . ')';
            },
        ));
    }
    
    public function preSetData(FormEvent $event)
    {
        $gallery = $event->getData();
        $form = $event->getForm();
        $categories = $gallery->getCategories();
        $cities = $gallery->getCities();

        $this->addUsersForm($form, $cities, $categories);
    }

    public function preSubmit(FormEvent $event)
    {
        $gallery = $event->getData();
        $form = $event->getForm();
        $categories = array_key_exists('categories', $gallery) ? $gallery['categories'] : array();
        $cities = array_key_exists('cities', $gallery) ? $gallery['cities'] : array();
        $this->addUsersForm($form, $cities, $categories);
    }

    public function getUsersByCitiesCategories($cities, $categories)
    {
        $er = $this->em->getRepository('FotoJoinUserBundle:User');
        $result = $er->getUsersByCitiesCategories($cities, $categories)->getQuery()->getResult();
        $users = array_column($result, 'user');
        $averages = array_column($result, 'average');
        foreach ($users as $key => $user) { $user->setAverage(number_format((float)$averages[$key], 2, '.', '')); }
        return $users;
    }
}