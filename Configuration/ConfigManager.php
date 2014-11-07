<?php

namespace Nefarian\CmsBundle\Configuration;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Nefarian\CmsBundle\Cache\CacheManager;
use Nefarian\CmsBundle\Cache\CacheProviderInterface;
use Nefarian\CmsBundle\Configuration\Event\ConfigFormBuildEvent;
use Nefarian\CmsBundle\Configuration\Form\ConfigSettingsForm;
use Nefarian\CmsBundle\Configuration\Form\ConfigurationSettingsForm;
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
    const CONFIG_FORM_BUILD = 'nefarian.configuration.form.build';

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
     * @var array
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

    /**
     * Rebuild all configuration values
     */
    public function rebuild()
    {
        foreach ($this->configs as $name => $defaults) {
            $this->set($name, new Configuration($defaults));
        }
        $this->eventDispatcher->dispatch(self::CONFIG_BUILD);
    }

    /**
     * Fetch a configuration object by name
     *
     * @param string $name
     * @return Configuration
     */
    public function get($name)
    {
        if (!$config = $this->cacheBin->fetch($name)) {
            $configEntity = $this->repository->find($name);
            if (!$configEntity instanceof Config) {
                return null;
            }

            $config = unserialize(stream_get_contents($configEntity->getValue()));
            $this->cacheBin->save($name, $config);
        }

        return $config;
    }

    /**
     * Set the value of a configuration
     *
     * @param string $name
     * @param Configuration $config
     */
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

    /**
     * Delete a config entity by name
     *
     * @param $name
     */
    public function delete($name)
    {
        $configEntity = $this->repository->find($name);
        $this->em->remove($configEntity);
        $this->em->flush($configEntity);
    }

    /**
     * Rename a config entity by name
     *
     * @param string $oldName
     * @param string $newName
     */
    public function rename($oldName, $newName)
    {
        $configEntity = $this->repository->find($oldName);
        $configEntity->setName($newName);
        $this->em->persist($configEntity);
        $this->em->flush($configEntity);
    }

    /**
     * Duplicates an existing configuration into a new name
     *
     * @param string $name
     * @param string $newName
     */
    public function duplicate($name, $newName)
    {
        $config = $this->get($name);
        if ($config) {
            $base = clone $config;
            $this->set($newName, $base);
        }
    }

    /**
     * Get a form for a config entity
     *
     * @param string $name
     * @return ConfigurationSettingsForm
     */
    public function getConfigForm($name)
    {
        $form = new ConfigurationSettingsForm($this->get($name));
        $this->eventDispatcher->dispatch(self::CONFIG_FORM_BUILD, new ConfigFormBuildEvent($form));
        return $form;
    }
} 
