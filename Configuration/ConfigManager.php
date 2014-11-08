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
    const CONFIG_BUILD = 'nefarian.configuration.build';
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
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * @var ConfigurationInterface[]
     */
    private $configurations;

    function __construct(EntityManager $em, CacheManager $cacheManager, EventDispatcher $eventDispatcher)
    {
        $this->em         = $em;
        $this->repository = $em->getRepository('NefarianCmsBundle:Config');

        $this->cacheBin        = $cacheManager->get('nefarian.config');
        $this->eventDispatcher = $eventDispatcher;
    }

    public function setBaseConfigurations(array $configurations)
    {
        $this->configurations = $configurations;
    }


    /**
     * Rebuild all configuration values
     *
     * Fires the event nefarian.configuration.build
     */
    public function rebuild()
    {
        foreach ($this->configurations as $name => $configuration) {
            $this->set($name, $configuration);
        }
        $this->eventDispatcher->dispatch(self::CONFIG_BUILD);
    }

    /**
     * Fetch a configuration object by name
     *
     * @param string $name
     *
     * @return ConfigurationInterface
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
     * @param string                 $name
     * @param ConfigurationInterface $configuration
     */
    public function set($name, ConfigurationInterface $configuration)
    {
        $configEntity = $this->repository->find($name);
        if (!$configEntity instanceof Config) {
            $configEntity = new Config();
            $configEntity->setName($name);
        }
        $configEntity->setValue(serialize($configuration));
        $this->em->persist($configEntity);
        $this->em->flush($configEntity);

        $this->cacheBin->save($name, $configuration);
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
} 
