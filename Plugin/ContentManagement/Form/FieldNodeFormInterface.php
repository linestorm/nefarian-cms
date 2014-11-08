<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Form;

use Nefarian\CmsBundle\Configuration\ConfigurationInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Field;

/**
 * Interface FieldNodeFormInterface
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface FieldNodeFormInterface
{
    function __construct(Field $field, ConfigurationInterface $configuration);
} 
