<?php

namespace Nefarian\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Nefarian\CmsBundle\Model\Config as BaseConfig;

/**
 * @ORM\Entity
 * @ORM\Table(name="config")
 */
class Config extends BaseConfig
{
} 
