<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Doctrine\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Nefarian\CmsBundle\Configuration\ConfigManager;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ContentTypeEventListener
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Doctrine\EventListener
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ContentTypeEventListener implements EventSubscriber
{
    /**
     * @var ConfigManager
     */
    protected $configManager;

    /**
     * @var array
     */
    protected $updatedContentTypes;

    /**
     * @var ContainerInterface
     */
    protected $container;

    function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @inheritdoc
     */
    public function getSubscribedEvents()
    {
        return array(
            'postPersist',
            'preUpdate',
            'postUpdate',
            'postRemove',
        );
    }

    /**
     * On post-persist, create a config entry
     *
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof ContentType) {
            $this->getConfigManager();
            foreach ($entity->getTypeFields() as $field) {
                $fieldConfigName = 'content_type.' . $entity->getName() . '.' . $field->getName();
                $this->configManager->duplicate($field->getField()->getName() . '.settings', $fieldConfigName);
            }
        }
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $object = $args->getObject();

        if ($object instanceof ContentType) {
            if ($args->hasChangedField('name')) {
                $this->getConfigManager();
                foreach ($object->getTypeFields() as $field) {
                    $oldFieldConfigName                             = 'content_type.' . $args->getOldValue('name') . '.' . $field->getName();
                    $newFieldConfigName                             = 'content_type.' . $args->getNewValue('name') . '.' . $field->getName();
                    $this->updatedContentTypes[$newFieldConfigName] = $oldFieldConfigName;
                }
            }
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $object = $args->getObject();

        if ($object instanceof ContentType) {
            $this->getConfigManager();
            foreach ($object->getTypeFields() as $field) {
                $newFieldConfigName = 'content_type.' . $object->getName() . '.' . $field->getName();
                $oldFieldConfigName = $this->updatedContentTypes[$newFieldConfigName];
                $this->configManager->rename($oldFieldConfigName, $newFieldConfigName);
            }
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof ContentType) {
            $this->getConfigManager();
            foreach ($entity->getTypeFields() as $field) {
                $fieldConfigName = 'content_type.' . $entity->getName() . '.' . $field->getName();
                $this->configManager->delete($fieldConfigName);
            }
        }
    }

    protected function getConfigManager()
    {
        return $this->configManager = $this->container->get('nefarian_core.config_manager');
    }

} 
