<?php

namespace Nefarian\CmsBundle\Plugin\FieldBody\Entity;

use Nefarian\CmsBundle\Plugin\FieldBody\Model\FieldBody as BaseFieldBody;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class FieldBody
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Entity
 * @author  Andy Thorne <contrabandvr@gmail.com>
 *
 * @ORM\Table(name="field_body")
 * @ORM\Entity
 */
class FieldBody extends BaseFieldBody
{

} 
