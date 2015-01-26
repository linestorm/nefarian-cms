<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Field\Widget\Form;

use Doctrine\ORM\EntityManager;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField;
use Nefarian\CmsBundle\Plugin\FieldTag\AutoComplete\TagAutoCompleteHandler;
use Nefarian\CmsBundle\Plugin\FieldTag\Field\Configuration\FieldTagConfiguration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TagAutoCompleteWidgetForm
 *
 * @package Nefarian\CmsBundle\Plugin\FieldTag\Field\Widget\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagAutoCompleteWidgetForm extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var TagAutoCompleteHandler
     */
    protected $handler;

    function __construct(EntityManager $em, TagAutoCompleteHandler $handler)
    {
        $this->em      = $em;
        $this->handler = $handler;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var FieldTagConfiguration $configuration */
        /** @var ContentTypeField $typeField */
        $typeField     = $options['content_type_field'];
        $configuration = $typeField->getConfig();
        $limit         = $configuration->getLimit();

        $builder
            ->add('tags', 'auto_complete', array(
                'handler' => $this->handler,
                'multiple' => $configuration->isMultiple(),
                'handler_options'  => array(
                    'parent' => $configuration->getTag()
                ),
                'limit'   => (int)$limit,
                'label'   => $limit == 1 ? null : $limit,
                'attr'    => array(
                    'class' => 'form-control content-tags'
                )
            ));
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Nefarian\CmsBundle\Plugin\FieldTag\Entity\FieldTag'
            )
        );

        $resolver->setRequired(array('content_type_field'));
        $resolver->setAllowedTypes(array(
            'content_type_field' => 'Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nefarian_plugin_field_tag_widget_autocomplete';
    }
}
