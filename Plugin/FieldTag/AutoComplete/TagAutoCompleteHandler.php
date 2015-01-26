<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\AutoComplete;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Nefarian\CmsBundle\Form\AutoComplete\AbstractAutoCompleteHandler;

class TagAutoCompleteHandler extends AbstractAutoCompleteHandler
{
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->dataClass     = '\Nefarian\CmsBundle\Plugin\FieldTag\Entity\NodeTag';
        $this->dataProperty  = 'name';
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions($term, array $options = array())
    {
        $options += array(
            'parent' => null,
        );

        $repo = $this->entityManager->getRepository($this->dataClass);

        $alias     = 't';
        $condition = $this->buildSearchCondition($term);

        $results = $repo->createQueryBuilder($alias)
            ->select($alias . '.' . $this->dataProperty)
            ->andwhere($alias . '.' . $this->dataProperty . ' LIKE :cond')
            ->andWhere($alias . '.parentTag = :parent')
            ->setParameters(array(
                'cond'   => $condition,
                'parent' => $options['parent']
            ))
            ->getQuery()->getArrayResult();

        $prop = $this->dataProperty;
        $options = array_map(function($a) use ($prop){
            return array(
                'id'   => $a[$prop],
                'text' => $a[$prop],
            );
        }, $results);

        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function getObjects(array $ids = array(), array $options = array())
    {
        $options += array(
            'parent' => null,
        );

        $objects = new ArrayCollection();
        foreach ($ids as $id) {
            $tag = $this->entityManager->getRepository($this->dataClass)->findOneBy(array(
                $this->dataProperty => $id,
                'parentTag' => $options['parent'],
            ));
            if ($tag instanceof $this->dataClass) {
                $objects[] = $tag;
            }
        }

        return $objects;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'field_tag';
    }
}
