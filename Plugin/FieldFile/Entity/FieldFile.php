<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Entity;

use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\NodeContent;

/**
 * Class FieldFile
 *
 * @package Nefarian\CmsBundle\Plugin\FieldFile\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldFile extends NodeContent
{
    /**
     * @var File
     */
    protected $file;

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File $file
     */
    public function setFile(File $file)
    {
        $this->file = $file;
    }

} 
