<?php

namespace Nefarian\CmsBundle\Doctrine;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Nefarian\CmsBundle\Plugin\Plugin;

class DoctrineOrmMapping
{
    /**
     * @var Configuration
     */
    protected $config;

    function __construct(EntityManager $em)
    {
        $this->config = $em->getConfiguration();
        $em->
    }

    public function addPlugin(Plugin $plugin)
    {
        $this->config->addEntityNamespace('Plugin'.$this->toCamelCase($plugin->getName()), $plugin->getNamespace().'\\Entity');
    }

    protected function toCamelCase($name)
    {
        $name   = preg_replace('/[^a-zA-Z0-9]/', ' ', $name);
        $string = ucwords(strtolower($name));

        return str_replace(' ', '', $string);
    }
}
