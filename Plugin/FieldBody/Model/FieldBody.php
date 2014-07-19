<?php

namespace Nefarian\CmsBundle\Plugin\FieldBody\Model;
use Nefarian\CmsBundle\Plugin\ContentManagement\Model\Node;

/**
 * Class FieldBody
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Model
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldBody
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var Node
     */
    protected $node;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param Node $node
     */
    public function setNode(Node $node)
    {
        $this->node = $node;
    }

    /**
     * @return Node
     */
    public function getNode()
    {
        return $this->node;
    }


} 
