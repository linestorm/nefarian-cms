<?php

namespace Nefarian\CmsBundle\View;

use Doctrine\ORM\EntityManager;

class ViewManager
{
    /**
     * @var EntityManager
     */
    protected $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getMetaData($type)
    {
        return $this->em->getClassMetadata($type);
    }

} 
