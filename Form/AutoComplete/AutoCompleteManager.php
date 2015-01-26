<?php

namespace Nefarian\CmsBundle\Form\AutoComplete;

/**
 * Class AutoCompleteManager
 *
 * @package Nefarian\CmsBundle\Form\AutoComplete
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class AutoCompleteManager
{
    /**
     * @var AutoCompleteHandlerInterface[]
     */
    protected $handlers = array();

    public function addHandler(AutoCompleteHandlerInterface $handler)
    {
        $this->handlers[$handler->getName()] = $handler;
    }

    public function getHandler($name)
    {
        if(isset($this->handlers[$name]))
        {
            return $this->handlers[$name];
        }
    }
}
