<?php

namespace Nefarian\CmsBundle\Plugin\Media\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nefarian\CmsBundle\Plugin\Media\Model\MediaResizeProfile as BaseResizeProfile;

/**
 * Class ResizeProfile
 *
 * @package Nefarian\CmsBundle\Plugin\Media\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class MediaResizeProfile extends BaseResizeProfile
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
