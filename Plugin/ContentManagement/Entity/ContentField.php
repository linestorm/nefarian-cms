<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Entity;

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
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="field", type="string")
 * @-ORM\DiscriminatorMap({"person" = "Person", "employee" = "Employee"})
 */
class ContentField extends BaseContentField
{
} 
