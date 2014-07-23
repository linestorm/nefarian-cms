<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Entity;

use Nefarian\CmsBundle\Plugin\ContentManagement\Model\Field as BaseField;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Field
 *
 * @package Nefarian\CmsBundle\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 *
 * @ORM\Table(name="field")
 * @ORM\Entity
 */
class Field extends BaseField
{
} 
