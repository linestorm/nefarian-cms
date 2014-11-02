<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Nefarian\CmsBundle\Plugin\FieldTag\Entity\NodeTag;

/**
 * Created by Andy Thorne
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class NodeTagRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAllRootTags()
    {
        $query = $this->createQueryBuilder('q')
            ->select('q')
            ->where('q.parentTag IS NULL');

        return $query->getQuery()->getResult();
    }

    /**
     * @param NodeTag $tag
     * @return array
     */
    public function findAllParentTags(NodeTag $tag)
    {
        $parents      = array();
        $parentEntity = $tag->getParentTag();
        $hasParents   = true;
        while ($hasParents) {
            if ($parentEntity instanceof NodeTag) {
                $parents[]    = $parentEntity;
                $parentEntity = $parentEntity->getParentTag();
            } else {
                $hasParents = false;
            }
        }

        return array_reverse($parents);
    }

    public function findAllCategories()
    {
        $query = $this->createQueryBuilder('t')
            ->select('t')
            ->where('size(t.childTags) = 0')
            ->orderBy('t.name', 'ASC');

        return $query->getQuery()->getResult();
    }

    public function findAllChildTags(NodeTag $tag)
    {
        return $this->getChildTags($tag->getChildTags());
    }

    /**
     * @param NodeTag[] $tags
     * @return array
     */
    protected function getChildTags($tags)
    {
        $tagOptions = array();
        foreach($tags as $childTag)
        {
            $tagOptions[] = $childTag;
            $tagOptions = array_merge($tagOptions, $this->getChildTags($childTag->getChildTags()));
        }

        return $tagOptions;
    }

} 
