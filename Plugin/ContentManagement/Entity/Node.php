<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Entity;

use Nefarian\CmsBundle\Plugin\ContentManagement\Model\Node as BaseNode;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Node
 *
 * @package Nefarian\CmsBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 *
 * @ORM\Table(name="node")
 * @ORM\Entity
 */
class Node extends BaseNode
{
} 
