<?php

namespace Nefarian\CmsBundle\Configuration;

interface ConfigurationInterface
{
    /**
     * @param $name
     *
     * @return void
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();
    /**
     * Get the type of the config
     *
     * @return string
     */
    public function getType();

    /**
     * The name of the parent config
     *
     * @return string
     */
    public function getParent();

    /**
     * The service or object of the form
     *
     * @return string|object
     */
    public function getForm();
} 
