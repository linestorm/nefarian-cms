<?php

namespace Nefarian\CmsBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use Nefarian\CmsBundle\Form\DataTransformer\HiddenEntityIdTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HiddenEntityIdType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setRequired(array(
                'data_class',
                'em'
            ))
            ->setAllowedTypes(array(
                'em' => 'Doctrine\Common\Persistence\ObjectManager',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        // this assumes that the entity manager was passed in as an option
        $entityManager = $options['em'];
        $dataClass = $options['data_class'];
        $transformer = new HiddenEntityIdTransformer($entityManager, $dataClass);

        $builder->addModelTransformer($transformer);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'hidden';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'hidden_entity';
    }

}
