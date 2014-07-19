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
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param ContentTypeField $typeField
     */
    public function addTypeField(ContentTypeField $typeField)
    {
        $this->typeFields[] = $typeField;
        $typeField->setContentField($this);
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
