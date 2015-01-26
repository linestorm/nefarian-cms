<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Field\Widget\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField;
use Nefarian\CmsBundle\Plugin\FieldTag\AutoComplete\TagAutoCompleteHandler;
use Nefarian\CmsBundle\Plugin\FieldTag\Field\Configuration\FieldTagConfiguration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class TagSelectWidgetForm
 *
 * @package Nefarian\CmsBundle\Plugin\FieldTag\Field\Widget\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagSelectWidgetForm extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
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
        $rootTag       = $configuration->getTag();

        $builder
            ->add('tags', 'collection', array(
                'type' => 'entity',
                'options' => array(
                    'class' => 'Nefarian\CmsBundle\Plugin\FieldTag\Entity\NodeTag',
                    'query_builder' => function(EntityRepository $er) use ($rootTag) {
                        return $er->createQueryBuilder('u')
                            ->where('u.parentTag = :tag')
                            ->orderBy('u.name', 'ASC')
                            ->setParameter('tag', $rootTag);
                    },
                    'multiple' => $configuration->isMultiple(),
                    'property' => 'name',
                    'empty_value' => '',
                    'empty_data' => null,
                    'required' => true,
                    'label' => false,
                ),
            ))
        ;
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
        return 'nefarian_plugin_field_tag_widget_select';
    }
}
