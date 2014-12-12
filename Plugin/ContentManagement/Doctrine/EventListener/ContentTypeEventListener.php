<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Doctrine\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Nefarian\CmsBundle\Configuration\ConfigManager;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField;
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
            Events::onFlush,
            Events::postPersist,
            Events::postRemove,
        );
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $em  = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        $this->getConfigManager();
        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof ContentType) {
                $changeSet = $uow->getEntityChangeSet($entity);
                if (isset($changeSet['name'])) {
                    list($oldValue, $newValue) = $changeSet['name'];
                    foreach ($entity->getTypeFields() as $field) {
                        $oldFieldConfigName = 'content_type.' . $oldValue . '.' . $field->getName();
                        $newFieldConfigName = 'content_type.' . $newValue . '.' . $field->getName();

                        $this->configManager->rename($oldFieldConfigName, $newFieldConfigName);
                    }
                }
            }

            if($entity instanceof ContentTypeField){
                $changeSet = $uow->getEntityChangeSet($entity);
                if (isset($changeSet['name'])) {
                    list($oldValue, $newValue) = $changeSet['name'];
                    $oldFieldConfigName = 'content_type.' . $entity->getContentType()->getName() . '.' . $oldValue;
                    $newFieldConfigName = 'content_type.' . $entity->getContentType()->getName() . '.' . $newValue;

                    $this->configManager->rename($oldFieldConfigName, $newFieldConfigName);
                }
            }
        }

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
