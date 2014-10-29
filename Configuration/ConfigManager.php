<?php

namespace Nefarian\CmsBundle\Configuration;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Nefarian\CmsBundle\Cache\CacheManager;
use Nefarian\CmsBundle\Cache\CacheProviderInterface;
use Nefarian\CmsBundle\Configuration\Form\ConfigSettingsForm;
use Nefarian\CmsBundle\Entity\Config;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class ConfigManager
 *
 * @package Nefarian\CmsBundle\Configuration
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ConfigManager
{
    const CONFIG_BUILD = 'nefarian.configuration.rebuild';

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * @var CacheProviderInterface
     */
    private $cacheBin;

    /**
     * @var string[]
     */
    private $configs;

    /**
     * @var EventDispatcher
     */
    private $eventDispatcher;

    function __construct(EntityManager $em, CacheManager $cacheManager, EventDispatcher $eventDispatcher)
    {
        $this->em         = $em;
        $this->repository = $em->getRepository('NefarianCmsBundle:Config');

        $this->cacheBin        = $cacheManager->get('nefarian.config');
        $this->eventDispatcher = $eventDispatcher;
    }

    public function addConfiguration($name, $config)
    {
        $this->configs[$name] = $config;
    }

    public function rebuild()
    {
        foreach ($this->configs as $name => $defaults) {
            $this->set($name, new Configuration($defaults));
        }
        $this->eventDispatcher->dispatch(self::CONFIG_BUILD);
    }

    public function get($name)
    {
        if (!$config = $this->cacheBin->fetch($name)) {
            $configEntity = $this->repository->find($name);
            if(!$configEntity instanceof Config)
            {
                return null;
            }

            $config       = unserialize(stream_get_contents($configEntity->getValue()));
            $this->cacheBin->save($name, $config);
        }

        return $config;
    }

    public function set($name, Configuration $config)
    {
        $configEntity = $this->repository->find($name);
        if (!$configEntity instanceof Config) {
            $configEntity = new Config();
            $configEntity->setName($name);
        }
        $configEntity->setValue(serialize($config));
        $this->em->persist($configEntity);
        $this->em->flush($configEntity);

        $this->cacheBin->save($name, $config);
    }

    public function duplicate($name, $newName)
    {
        $config = $this->get($name);
        if($config)
        {
            $base = clone $config;
            $this->set($newName, $base);
        }
    }

    public function getConfigForm($name)
    {
        $config = $this->get($name);
        return new ConfigSettingsForm($config);
    }


} 
