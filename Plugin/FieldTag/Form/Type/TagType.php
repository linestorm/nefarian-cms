<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Form\Type;

use Doctrine\ORM\EntityManager;
use Nefarian\CmsBundle\Plugin\FieldTag\Form\DataTransformer\TagTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TagType extends AbstractType
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
        $resolver
            ->setDefaults(array(
                'name' => null
            ))
            ->setRequired(array(
                'tag_class',
                'tag_base'
            ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $dataClass   = $options['tag_class'];
        $transformer = new TagTransformer($this->em, $dataClass);

        $builder->addModelTransformer($transformer);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        /** @var EntityManager $entityManager */
        $dataClass = $options['tag_class'];
        $name      = $options['name'];
        $tags      = array();

        if($name)
        {
            $repo = $this->em->getRepository($dataClass);
            if(!$options['tag_base']){
                $tagArray = $repo->findAll();
            } else {
                $baseTag = $repo->find($options['tag_base']);
                $tagArray = $repo->findAllChildTags($baseTag);
            }

            foreach($tagArray as $tagData)
            {
                $tags[] = $tagData->getName();
            }
        }

        $view->vars['attr']['data-options'] = implode(',', $tags);
    }


    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'tag';
    }
}
