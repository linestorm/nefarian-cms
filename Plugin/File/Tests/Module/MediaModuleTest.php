<?php

namespace Nefarian\CmsBundle\Plugin\File\Tests\Module;

use LineStorm\CmsBundle\Module\ModuleInterface;
use LineStorm\CmsBundle\Tests\Module\ModuleTest;
use Nefarian\CmsBundle\Plugin\File\Module\FileModule;

/**
 * Unit tests for file module
 *
 * Class FileModuleTest
 *
 * @package Nefarian\CmsBundle\Plugin\File\Tests\Module
 */
class FileModuleTest extends ModuleTest
{
    protected $id = 'file';
    protected $name = 'File';

    /**
     * @return ModuleInterface
     */
    protected function getModule()
    {
        return new FileModule();
    }
} 
