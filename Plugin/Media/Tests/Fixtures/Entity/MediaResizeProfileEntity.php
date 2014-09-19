<?php

namespace Nefarian\CmsBundle\Plugin\Media\Tests\Fixtures\Entity;

use Nefarian\CmsBundle\Plugin\Media\Entity\MediaResizeProfile;

/**
 * Media entity fixture
 *
 * Class MediaEntity
 *
 * @package Nefarian\CmsBundle\Plugin\Media\Tests\Fixtures\Entity
 */
class MediaResizeProfileEntity extends MediaResizeProfile
{
    protected $id = 1;

    protected $name = 'test';

    protected $width = 200;

    protected $height = 200;
} 
