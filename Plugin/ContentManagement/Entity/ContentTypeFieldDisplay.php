<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Entity;

use Nefarian\CmsBundle\Plugin\ContentManagement\Model\ContentTypeFieldDisplay as BaseContentTypeFieldDisplay;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Field
 *
 * @package Nefarian\CmsBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 *
 * @ORM\Table(name="content_type_field_display")
 * @ORM\Entity
 */
class ContentTypeFieldDisplay extends BaseContentTypeFieldDisplay
{
} 
