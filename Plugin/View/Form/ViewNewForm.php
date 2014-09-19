<?php

namespace Nefarian\CmsBundle\Plugin\View\Form;

use Doctrine\ORM\Mapping\ClassMetadata;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ViewNewForm extends AbstractType
{
    /**
     * @var ClassMetadata[]
     */
    protected $meta;

    function __construct(array $classMetadata)
    {
        $this->meta = $classMetadata;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $entities = array();
        foreach($this->meta as $metaData)
        {
            if(!$metaData->isMappedSuperclass)
            {
                $entities[] = $metaData->getName();
            }
        }

        $builder
            ->add('name', 'text')
            ->add('description', 'textarea', array(
                'required' => false
            ))
            ->add('base_entity', 'choice', array(
                'choices' => $entities
            ))
            ->add('fields', 'collection', array(
                'type'         => 'text',
                'allow_add'    => true,
                'allow_delete' => true,
            ));
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {

    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nefarian_plugin_view_new';
    }
}
