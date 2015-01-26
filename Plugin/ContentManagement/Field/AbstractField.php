<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Field;

use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Display\DisplayInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Field\Widget\WidgetInterface;

abstract class AbstractField implements FieldInterface
{
    /**
     * @var DisplayInterface
     */
    protected $display;

    /**
     * @var WidgetInterface
     */
    protected $widget;

    /**
     * @return DisplayInterface
     */
    public function getDisplay()
    {
        if(!$this->display instanceof DisplayInterface)
        {
            $this->display = $this->getDefaultDisplay();
        }

        return $this->display;
    }

    /**
     * @return WidgetInterface
     */
    public function getWidget()
    {
        if(!$this->widget instanceof WidgetInterface)
        {
            $this->widget = $this->getDefaultWidget();
        }

        return $this->widget;
    }

    /**
     * @return DisplayInterface
     */
    abstract protected function getDefaultDisplay();

    /**
     * @return WidgetInterface
     */
    abstract protected function getDefaultWidget();
}
