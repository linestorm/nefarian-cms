<?php

namespace Nefarian\CmsBundle\Plugin\FieldBody\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\NodeContent;

/**
 * Class FieldBody
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="field_body")
 */
class FieldBody extends NodeContent
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
}
