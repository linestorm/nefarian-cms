<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Form;

use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField;

/**
 * Interface FieldNodeFormInterface
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Form
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
interface FieldNodeFormInterface
{
    /**
     * @param ContentTypeField $field
     */
    function __construct(ContentTypeField $field);
} 
