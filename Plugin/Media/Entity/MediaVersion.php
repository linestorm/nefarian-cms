<?php

namespace Nefarian\CmsBundle\Plugin\Media\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nefarian\CmsBundle\Plugin\Media\Model\MediaVersion as BaseMediaVersion;

/**
 * Class MediaVersion
 *
 * @package Nefarian\CmsBundle\Plugin\Media\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class MediaVersion extends BaseMediaVersion
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
     * @var MediaResizeProfile
     *
     * @ORM\ManyToOne(targetEntity="MediaResizeProfile")
     */
    protected $resizeProfile;

    /**
     * @var Media
     *
     * @ORM\ManyToOne(targetEntity="Media", inversedBy="versions")
     */
    protected $media;

} 
