<?php

namespace Nefarian\CmsBundle\Plugin\Media\Tests\Module;

use LineStorm\CmsBundle\Module\ModuleInterface;
use LineStorm\CmsBundle\Tests\Module\ModuleTest;
use Nefarian\CmsBundle\Plugin\Media\Module\MediaModule;

/**
 * Unit tests for media module
 *
 * Class MediaModuleTest
 *
 * @package Nefarian\CmsBundle\Plugin\Media\Tests\Module
 */
class MediaModuleTest extends ModuleTest
{
    protected $id = 'media';
    protected $name = 'Media';

    /**
     * @return ModuleInterface
     */
    protected function getModule()
    {
        return new MediaModule();
    }
} 
