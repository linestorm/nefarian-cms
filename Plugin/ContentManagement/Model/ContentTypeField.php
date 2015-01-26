<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Nefarian\CmsBundle\Plugin\ContentManagement\Configuration\FieldConfiguration;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeFieldWidget;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Configuration\FieldSettingsConfiguration;

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
     * @var NodeContent[]
     */
    protected $contents;

    /**
     * @var Field
     */
    protected $field;

    /**
     * @var FieldSettingsConfiguration
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
     * @var ContentTypeFieldWidget
     */
    protected $viewWidget;

    /**
     * @var ContentTypeFieldDisplay
     */
    protected $viewDisplay;

    /**
     * @var int
     */
    protected $order;

    function __construct()
    {
        $this->contents = new ArrayCollection();
    }

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
     * @param FieldSettingsConfiguration $config
     */
    public function setConfig(FieldSettingsConfiguration $config)
    {
        $this->config = $config;
    }

    /**
     * @return NodeContent[]
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @param NodeContent $content
     */
    public function addContents($content)
    {
        $this->contents[] = $content;
    }

    /**
     * @param NodeContent $content
     */
    public function removeContents($content)
    {
        $this->contents->removeElement($content);
    }

    /**
     * @return ContentTypeFieldWidget
     */
    public function getViewWidget()
    {
        return $this->viewWidget;
    }

    /**
     * @param ContentTypeFieldWidget $viewWidget
     */
    public function setViewWidget(ContentTypeFieldWidget $viewWidget)
    {
        $this->viewWidget = $viewWidget;
    }

    /**
     * @return ContentTypeFieldDisplay
     */
    public function getViewDisplay()
    {
        return $this->viewDisplay;
    }

    /**
     * @param ContentTypeFieldDisplay $viewDisplay
     */
    public function setViewDisplay(ContentTypeFieldDisplay $viewDisplay)
    {
        $this->viewDisplay = $viewDisplay;
    }

} 
