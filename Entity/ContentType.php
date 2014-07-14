<?php

namespace Nefarian\CmsBundle\Entity;

use Nefarian\CmsBundle\Plugin\ContentManagement\Model\ContentType as BaseContentType;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class ContentType
 *
 * @package Nefarian\CmsBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 *
 * @ORM\Table(name="content_type")
 * @ORM\Entity
 */
class ContentType extends BaseContentType
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
} 
