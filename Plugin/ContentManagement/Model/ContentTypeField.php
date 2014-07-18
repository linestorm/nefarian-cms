<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Model;

class ContentTypeField
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var ContentType
     */
    protected $contentType;

    /**
     * @var ContentField
     */
    protected $contentField;

    /**
     * @TODO: implement
     *
     * @ var DisplayType
     * protected $displayType;
     */

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $order;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param int $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param ContentField $contentField
     */
    public function setContentField(ContentField $contentField)
    {
        $this->contentField = $contentField;
    }

    /**
     * @return ContentField
     */
    public function getContentField()
    {
        return $this->contentField;
    }

    /**
     * @param ContentType $contentType
     */
    public function setContentType(ContentType $contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * @return ContentType
     */
    public function getContentType()
    {
        return $this->contentType;
    }



} 
