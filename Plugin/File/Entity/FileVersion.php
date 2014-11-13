<?php

namespace Nefarian\CmsBundle\Plugin\File\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nefarian\CmsBundle\Plugin\File\Model\FileVersion as BaseFileVersion;

/**
 * Class FileVersion
 *
 * @package Nefarian\CmsBundle\Plugin\File\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class FileVersion extends BaseFileVersion
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
     * @var FileResizeProfile
     *
     * @ORM\ManyToOne(targetEntity="FileResizeProfile")
     */
    protected $resizeProfile;

    /**
     * @var File
     *
     * @ORM\ManyToOne(targetEntity="File", inversedBy="versions")
     */
    protected $file;

} 
