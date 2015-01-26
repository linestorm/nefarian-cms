<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Field\Configuration;

use Nefarian\CmsBundle\Configuration\AbstractConfiguration;
use Nefarian\CmsBundle\Configuration\Configuration;
use Nefarian\CmsBundle\Plugin\ContentManagement\Configuration\Field\View\Form\FormConfigurationInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\FieldSettingsInterface;

/**
 * Class FieldConfiguration
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Field\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class FieldSettingsConfiguration extends AbstractConfiguration implements FieldSettingsInterface
{
    const LIMIT_UNLIMITED = -1;

    protected $limit = 1;

    protected $viewForm;

    protected $viewDisplay;

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return FormConfigurationInterface
     */
    public function getViewForm()
    {
        return $this->viewForm;
    }

    /**
     * @param mixed $viewForm
     */
    public function setViewForm($viewForm)
    {
        $this->viewForm = $viewForm;
    }

    /**
     * @return mixed
     */
    public function getViewDisplay()
    {
        return $this->viewDisplay;
    }

    /**
     * @param mixed $viewDisplay
     */
    public function setViewDisplay($viewDisplay)
    {
        $this->viewDisplay = $viewDisplay;
    }
    
} 
