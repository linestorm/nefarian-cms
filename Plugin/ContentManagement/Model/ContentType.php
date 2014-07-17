<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Model;

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
     * @param ContentTypeField $typeField
     */
    public function addTypeFields(ContentTypeField $typeField)
    {
        $this->typeFields[] = $typeField;
    }

    /**
     * @param ContentTypeField $typeField
     */
    public function removeTypeFields(ContentTypeField $typeField)
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
