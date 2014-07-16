<?php

namespace Nefarian\CmsBundle\Entity;

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
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var ContentType
     *
     * @ORM\ManyToOne(targetEntity="ContentType", cascade={"persist"})
     */
    protected $contentType;
} 
