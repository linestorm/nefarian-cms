<?php

namespace Nefarian\CmsBundle\Plugin\File\Tests\File;
use Nefarian\CmsBundle\Plugin\File\File\FileProviderInterface;

/**
 * Unit tests for File Provider
 *
 * Class LocalStorageFileProviderTest
 *
 * @package Nefarian\CmsBundle\Plugin\File\Tests\File
 */
abstract class AbstractFileProviderTest extends \PHPUnit_Framework_TestCase
{
    protected $id;
    protected $form;

    /**
     * @param null $repository
     *
     * @return FileProviderInterface
     */
    abstract protected function getProvider($repository = null);

    public function testId()
    {
        $provider = $this->getProvider();

        $id = $provider->getId();
        $this->assertEquals($id, $this->id);
    }

    public function testForm()
    {
        $provider = $this->getProvider();

        $form = $provider->getForm();
        $this->assertEquals($form, $this->form);
    }

    abstract public function testFind();
}
