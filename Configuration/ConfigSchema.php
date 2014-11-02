<?php

namespace Nefarian\CmsBundle\Configuration;

/**
 * Container class of configuration schema. Properties are public of access speed
 *
 * Created by Andy Thorne
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ConfigSchema
{
    /**
     * @var string
     */
    public $type;

    /**
     * @var array
     */
    public $options;

    function __construct($type, array $options = array())
    {
        $this->type    = $type;
        $this->options = $options;
    }

} 
