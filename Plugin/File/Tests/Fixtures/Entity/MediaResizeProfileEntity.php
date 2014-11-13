<?php

namespace Nefarian\CmsBundle\Plugin\File\Tests\Fixtures\Entity;

use Nefarian\CmsBundle\Plugin\File\Entity\FileResizeProfile;

/**
 * File entity fixture
 *
 * Class FileEntity
 *
 * @package Nefarian\CmsBundle\Plugin\File\Tests\Fixtures\Entity
 */
class FileResizeProfileEntity extends FileResizeProfile
{
    protected $id = 1;

    protected $name = 'test';

    protected $width = 200;

    protected $height = 200;
} 
