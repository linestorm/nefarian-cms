<?php

namespace Nefarian\CmsBundle\Plugin\File\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nefarian\CmsBundle\Plugin\File\Model\FileResizeProfile as BaseResizeProfile;

/**
 * Class ResizeProfile
 *
 * @package Nefarian\CmsBundle\Plugin\File\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class FileResizeProfile extends BaseResizeProfile
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
