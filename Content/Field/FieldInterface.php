<?php

namespace Nefarian\CmsBundle\Content\Field;

interface FieldInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getForm();

    /**
     * Returns the entity class
     *
     * @return mixed
     */
    public function getEntityClass();
} 
