<?php

namespace Nefarian\CmsBundle\Plugin\File\Model;

/**
 * Class FileVersion
 *
 * @package Nefarian\CmsBundle\Plugin\File\Model
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FileVersion
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var FileResizeProfile
     */
    protected $resizeProfile;

    /**
     * @var File
     */
    protected $file;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $src;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param File $file
     */
    public function setFile(File $file)
    {
        $this->file = $file;
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param FileResizeProfile $resizeProfile
     */
    public function setResizeProfile(FileResizeProfile $resizeProfile)
    {
        $this->resizeProfile = $resizeProfile;
    }

    /**
     * @return FileResizeProfile
     */
    public function getResizeProfile()
    {
        return $this->resizeProfile;
    }

    /**
     * @param string $src
     */
    public function setSrc($src)
    {
        $this->src = $src;
    }

    /**
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Returns the image height
     *
     * @return int
     */
    public function getHeight()
    {
        if($this->path)
        {
            $size = getimagesize($this->path);
            return $size[1];
        }

        return 0;
    }

    /**
     * Returns the image width
     *
     * @return int
     */
    public function getWidth()
    {
        if($this->path)
        {
            $size = getimagesize($this->path);
            return $size[0];
        }

        return 0;
    }

} 
