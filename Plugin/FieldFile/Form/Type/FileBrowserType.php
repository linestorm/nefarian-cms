<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Form\Type;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class FileBrowserType
 *
 * @package Nefarian\CmsBundle\Plugin\FieldFile\Form\Type
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileBrowserType extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'em' => $this->entityManager,
        ));
    }


    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'hidden_entity';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'file_browser';
    }
}
