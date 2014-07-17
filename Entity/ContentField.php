<?php

namespace Nefarian\CmsBundle\Entity;

use Nefarian\CmsBundle\Plugin\ContentManagement\Model\ContentField as BaseContentField;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ContentFieldType
 *
 * @package Nefarian\CmsBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 *
 * @ORM\Table(name="content_field")
 * @ORM\Entity
 */
class ContentField extends BaseContentField
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var ContentTypeField[]
     *
     * @ORM\OneToMany(targetEntity="ContentTypeField", mappedBy="contentField", cascade={"persist"})
     */
    protected $typeFields;
} 
