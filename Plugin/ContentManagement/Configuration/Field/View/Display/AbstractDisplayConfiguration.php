<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Configuration\Field\View\Display;

use Nefarian\CmsBundle\Configuration\AbstractConfiguration;

/**
 * Class AbstractDisplayConfiguration
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Configuration\Field\View\Display
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class AbstractDisplayConfiguration extends AbstractConfiguration
{
    /**
     * Get the supported field
     *
     * @return string
     */
    abstract public function getSupportedField();

    /**
     * @return string
     */
    abstract public function getViewFormClass();
} 
