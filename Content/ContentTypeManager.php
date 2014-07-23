<?php

namespace Nefarian\CmsBundle\Content;

use Doctrine\ORM\EntityManager;
use Nefarian\CmsBundle\Content\Field\FieldManager;
use Nefarian\CmsBundle\Content\Field\Field;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;

class ContentTypeManager
{
    /**
     * @var FieldManager
     */
    protected $fieldManager;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @param EntityManager       $em
     * @param FieldManager $fieldManager
     */
    function __construct(EntityManager $em, FieldManager $fieldManager)
    {
        $this->em           = $em;
        $this->fieldManager = $fieldManager;
    }

    /**
     * Create a new entity
     *
     * @return ContentType
     */
    public function create()
    {
        return new ContentType();
    }

    /**
     * Add a field to the content type instance
     *
     * @param ContentType $contentType
     * @param Field       $field
     */
    public function addField(ContentType $contentType, Field $field)
    {
        $contentType->addField($field);
    }

} 
