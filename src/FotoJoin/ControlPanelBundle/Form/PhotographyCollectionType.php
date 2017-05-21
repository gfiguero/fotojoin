<?php

namespace FotoJoin\ControlPanelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Vich\UploaderBundle\Form\DataTransformer\FileTransformer;
use Vich\UploaderBundle\Handler\UploadHandler;
use Vich\UploaderBundle\Storage\StorageInterface;

class PhotographyCollectionType extends AbstractType
{
    protected $storage;
    protected $handler;
    protected $translator;
    public function __construct(StorageInterface $storage, UploadHandler $handler, TranslatorInterface $translator)
    {
        $this->storage = $storage;
        $this->handler = $handler;
        $this->translator = $translator;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'allow_delete'  => false,
            'download_link' => false,
            'error_bubbling' => false,
        ));
    }
    // BC for SF < 2.7
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', 'Symfony\Component\Form\Extension\Core\Type\CollectionType', array(
            'entry_type'   => $this->getFieldType('file'),
            'required' => false,
            'label'    => false,
        ));
        $builder->addModelTransformer(new FileTransformer());
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
        return 'photography_collection';
    }
    public function getName()
    {
        return $this->getBlockPrefix();
    }
    protected function getFieldType($shortType)
    {
        if (method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix')) {
            return sprintf('Symfony\Component\Form\Extension\Core\Type\%sType', ucfirst($shortType));
        }
        return $shortType;
    }
}