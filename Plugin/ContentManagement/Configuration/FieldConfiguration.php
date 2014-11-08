<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Configuration;

use Nefarian\CmsBundle\Configuration\AbstractConfiguration;
use Nefarian\CmsBundle\Configuration\Configuration;

/**
 * Class FieldConfiguration
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
abstract class FieldConfiguration extends AbstractConfiguration
{
    const LIMIT_UNLIMITED = -1;

    protected $limit = 1;

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
} 
