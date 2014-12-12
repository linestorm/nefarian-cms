<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Model;

use Nefarian\CmsBundle\Plugin\ContentManagement\Configuration\ContentTypeFieldConfiguration;
use Nefarian\CmsBundle\Plugin\ContentManagement\Configuration\FieldConfiguration;

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
     * @var Field
     */
    protected $field;

    /**
     * @var FieldConfiguration
     */
    protected $config;

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
     * @var string
     */
    protected $label;

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
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
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
     * @param Field $field
     */
    public function setField(Field $field)
    {
        $this->field = $field;
    }

    /**
     * @return Field
     */
    public function getField()
    {
        return $this->field;
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

    /**
     * @return FieldConfiguration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param FieldConfiguration $config
     */
    public function setConfig(FieldConfiguration $config)
    {
        $this->config = $config;
    }
} 
