<?php
namespace Nefarian\CmsBundle\Plugin\FieldBody\Form;

use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class NodeForm
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldBodyForm extends AbstractType
{
    /**
     * @var ContentType
     */
    protected $contentType;

    /**
     * @param ContentType $contentType
     */
    function __construct(ContentType $contentType)
    {
        $this->contentType = $contentType;
    }


    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('body', 'textarea');
    }

    /**
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nefarian\CmsBundle\Plugin\FieldBody\Entity\FieldBody'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nefarian_plugin_field_body';
    }
}
