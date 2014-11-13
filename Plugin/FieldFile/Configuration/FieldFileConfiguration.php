<?php

namespace Nefarian\CmsBundle\Plugin\FieldFile\Configuration;

use Nefarian\CmsBundle\Plugin\ContentManagement\Configuration\FieldConfiguration;
use Nefarian\CmsBundle\Plugin\FieldFile\Form\FieldFileSettingsForm;

/**
 * Class FieldFileConfiguration
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldFileConfiguration extends FieldConfiguration
{
    protected $fileTypes = array();

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'field.file';
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return new FieldFileSettingsForm();
    }

    /**
     * @return array
     */
    public function getFileTypes()
    {
        return $this->fileTypes;
    }

    /**
     * @param array $fileTypes
     */
    public function setFileTypes(array $fileTypes)
    {
        $this->fileTypes = $fileTypes;
    }

    protected function hasFileType($fileType)
    {
        return array_search($fileType, $this->fileTypes);
    }

} 
