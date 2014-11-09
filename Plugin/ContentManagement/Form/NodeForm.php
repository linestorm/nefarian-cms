<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Form;

use Nefarian\CmsBundle\Content\Field\FieldManager;
use Nefarian\CmsBundle\Content\Field\Field;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Node;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NodeForm extends AbstractType
{

    /**
     * @var FieldManager
     */
    protected $fieldManager;

    /**
     * @param FieldManager $fieldManager
     */
    function __construct(FieldManager $fieldManager)
    {
        $this->fieldManager = $fieldManager;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $node = $event->getData();
            $form = $event->getForm();

            if(!$node instanceof Node)
            {
                throw new \Exception('Form entity must be of type Node');
            }

            $form->add('contents', 'field_collection', array(
                'label' => false,
                'node'  => $node,
                'by_reference' => false,
            ));
        });

        $builder
            ->add('title', 'text')
            ->add('description', 'text', array(
                'required' => false
            ))
            ->add('published', 'checkbox')
            ->add('publishedOn', 'datetime', array(
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
            ))
        ;
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Node',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nefarian_plugin_content_management_node';
    }
}
