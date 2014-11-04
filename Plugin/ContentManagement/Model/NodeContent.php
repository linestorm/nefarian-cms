<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Model;

abstract class NodeContent
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
     * @var Node
     */
    protected $node;

    /**
     * @var ContentTypeField
     */
    protected $fieldType;

    /**
     * @var int
     */
    protected $delta;

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
     * @param Node $node
     */
    public function setNode(Node $node)
    {
        $this->node = $node;
    }

    /**
     * @return Node
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * @param ContentTypeField $fieldType
     */
    public function setFieldType(ContentTypeField $fieldType)
    {
        $this->fieldType = $fieldType;
    }

    /**
     * @return ContentTypeField
     */
    public function getFieldType()
    {
        return $this->fieldType;
    }

    /**
     * @return int
     */
    public function getDelta()
    {
        return $this->delta;
    }

    /**
     * @param int $delta
     */
    public function setDelta($delta)
    {
        $this->delta = $delta;
    }

} 
