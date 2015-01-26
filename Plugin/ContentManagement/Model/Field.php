<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Model;

use Doctrine\Common\Collections\ArrayCollection;

abstract class Field
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
     * Initialisation
     */
    function __construct()
    {
        $this->typeFields = new ArrayCollection();
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
     * @param ContentTypeField $typeField
     */
    public function addTypeField(ContentTypeField $typeField)
    {
        $this->typeFields[] = $typeField;
        $typeField->setField($this);
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

} 
