<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Model;

use Doctrine\Common\Collections\ArrayCollection;

class ContentField
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $category;

    /**
     * @var ContentType[]
     */
    protected $types;

    /**
     * Initialisation
     */
    function __construct()
    {
        $this->types = new ArrayCollection();
    }

} 
