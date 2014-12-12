<?php

namespace Nefarian\CmsBundle\Plugin\View\View;

/**
 * Class ViewForm
 *
 * @package Nefarian\CmsBundle\Plugin\View\View
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ViewForm
{
    protected $fields;

    protected $associations;

    public function addField($name, $type)
    {
        $this->fields[$name] = $type;

        return $this;
    }

    public function addAssociation($name, $type)
    {
        $this->associations[$name] = $type;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAssociations()
    {
        return $this->associations;
    }

    /**
     * @return mixed
     */
    public function getFields()
    {
        return $this->fields;
    }


    public function getParent()
    {
        return 'form';
    }
}
