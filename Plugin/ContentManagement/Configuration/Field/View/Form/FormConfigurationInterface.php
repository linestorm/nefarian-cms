<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Configuration\Field\View\Form;

/**
 * Interface FormConfigurationInterface
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface FormConfigurationInterface
{
    /**
     * Get the supported field
     *
     * @return string
     */
    public function getSupportedField();

    /**
     * @return string
     */
    public function getViewFormClass();

    /**
     * @return string
     */
    public function getViewName();
}
