<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Entity;

use Nefarian\CmsBundle\Plugin\ContentManagement\Model\NodeContent as BaseNodeContent;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class NodeContentType
 *
 * @package Nefarian\CmsBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 *
 * @ORM\Table(name="node_content")
 * @ORM\Entity
 */
class NodeContent extends BaseNodeContent
{
} 
