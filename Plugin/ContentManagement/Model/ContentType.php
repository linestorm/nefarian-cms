<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class ContentType
 *
 * @package Nefarian\CmsBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ContentType
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
     * @var ContentTypeField[]
     */
    protected $typeFields;

    /**
     * @var Node[]
     */
    protected $nodes;

    /**
     * @var string
     *
     * @Assert\Regex(
     *      pattern="/^(\/[\w\d-]+|\/\[[\w\d-]+:[\w\d-]+\])+$/",
     *      message="Format must follow a path structure (e.g. /node/[node:title]")
     * )
     */
    protected $pathFormat;

    /**
     * Initialisation
     */
    function __construct()
    {
        $this->typeFields = new ArrayCollection();
        $this->nodes      = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
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
     * @param ContentTypeField $typeField
     */
    public function addTypeField(ContentTypeField $typeField)
    {
        $this->typeFields[] = $typeField;
        $typeField->setContentType($this);
    }

    /**
     * @param ContentTypeField $typeField
     */
    public function removeTypeField(ContentTypeField $typeField)
    {
        $this->typeFields->removeElement($typeField);
    }

    /**
     * @return ContentTypeField[]
     */
    public function getTypeFields()
    {
        return $this->typeFields;
    }


    /**
     * @param Node $node
     */
    public function addNode(Node $node)
    {
        $this->nodes[] = $node;
    }

    /**
     * @param Node $node
     */
    public function removeNode(Node $node)
    {
        $this->nodes->removeElement($node);
    }

    /**
     * @return Node[]
     */
    public function getNodes()
    {
        return $this->typeFields;
    }

    /**
     * @return string
     */
    public function getPathFormat()
    {
        return $this->pathFormat;
    }

    /**
     * @param string $pathFormat
     */
    public function setPathFormat($pathFormat)
    {
        $this->pathFormat = $pathFormat;
    }


} 
