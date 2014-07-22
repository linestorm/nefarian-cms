<?php

namespace Nefarian\CmsBundle\Plugin\FieldBody\Entity;

use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentField;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Node;
use Nefarian\CmsBundle\Plugin\FieldBody\Model\FieldBody as BaseFieldBody;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class FieldBody
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="field_body")
 */
class FieldBody extends ContentField
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
