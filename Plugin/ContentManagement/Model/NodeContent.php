<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Model;

use Doctrine\Common\Collections\ArrayCollection;

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
     * @var Field
     */
    protected $field;

    /**
     * @var ContentTypeField
     */
    protected $fieldType;

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



} 
