<?php

namespace Nefarian\CmsBundle\Model\Manager;

use Nefarian\CmsBundle\Model\Manager\Exception\ModelNotFoundException;

/**
 * Class ModelManager
 *
 * @package Nefarian\CmsBundle\Model\Manager
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ModelManager
{
    protected $models = array();

    /**
     * @param $name
     * @param $model
     */
    public function addModel($name, $model)
    {
        $model[$name] = $model;
    }

    /**
     * @param $name
     *
     * @throws Exception\ModelNotFoundException
     * @return object
     */
    public function getModel($name)
    {
        if(!array_key_exists($name, $this->models))
        {
            throw new ModelNotFoundException();
        }

        return $this->models[$name];
    }

}
