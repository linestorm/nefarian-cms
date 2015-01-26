<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Form\Type;

use Doctrine\ORM\EntityManager;
use Nefarian\CmsBundle\Plugin\FieldTag\Model\NodeTag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TagChoiceType extends AbstractType
{
    /**
     * @var EntityManager
     */
    protected $em;

    function __construct($em)
    {
        $this->em = $em;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        /** @var NodeTag[] $options */
        $options = $this->em->getRepository('PluginFieldTag:NodeTag')->findAllRootTags();

        $entityOptions = $this->getChildTags($options);

        $resolver
            ->setDefaults(array(
                'class' => 'Nefarian\CmsBundle\Plugin\FieldTag\Entity\NodeTag',
                'root_tag' => null,
                'choices' => $entityOptions,
                'property' => 'name',
            ));
    }

    /**
     * @param NodeTag[] $tags
     * @param int $delta
     * @return array
     */
    protected function getChildTags($tags, $delta=0)
    {
        $tagOptions = array();
        foreach($tags as $childTag)
        {
            $tagOptions[$childTag->getId()] = str_repeat('--', $delta) . '  ' . ucfirst($childTag->getName());
            $childChildTags = $this->getChildTags($childTag->getChildTags(), $delta + 1);
            foreach($childChildTags as $id=>$value)
            {
                $tagOptions[$id] = $value;
            }
        }

        return $tagOptions;
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'tag_choice';
    }
}
