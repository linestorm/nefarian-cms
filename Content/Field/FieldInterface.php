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
     * @return array
     */
    public function getProperties();

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getProperty($name);

    /**
     * Returns the entity class
     *
     * @return mixed
     */
    public function getEntityClass();
} 
