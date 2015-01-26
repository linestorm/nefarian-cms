<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Model;

use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Display\DisplaySettingsInterface;

abstract class ContentTypeFieldDisplay
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
    protected $label;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var int
     */
    protected $order;

    /**
     * @var ContentTypeField
     */
    protected $typeField;

    /**
     * @var DisplaySettingsInterface
     */
    protected $config;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param int $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * @return ContentTypeField
     */
    public function getTypeField()
    {
        return $this->typeField;
    }

    /**
     * @param ContentTypeField $typeField
     */
    public function setTypeField(ContentTypeField $typeField)
    {
        $this->typeField = $typeField;
    }

    /**
     * @return DisplaySettingsInterface
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param DisplaySettingsInterface $config
     */
    public function setConfig(DisplaySettingsInterface $config)
    {
        $this->config = $config;
    }
} 
