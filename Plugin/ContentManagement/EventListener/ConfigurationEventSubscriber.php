<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\EventListener;

use Doctrine\ORM\EntityManager;
use Nefarian\CmsBundle\Configuration\ConfigManager;
use Nefarian\CmsBundle\Configuration\ConfigurationInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ConfigurationEventListener
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Controller
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class ConfigurationEventSubscriber implements EventSubscriberInterface
{
    /**
     * @var ConfigManager
     */
    protected $configManager;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    function __construct(ConfigManager $configManager, EntityManager $entityManager)
    {
        $this->configManager = $configManager;
        $this->entityManager = $entityManager;
    }


    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            ConfigManager::CONFIG_BUILD => array(
                array('onConfigRebuild', 10),
            )
        );
    }

    public function onConfigRebuild(Event $event)
    {
        /** @var ContentType[] $contentTypes */
        $contentTypes = $this->entityManager->getRepository('PluginContentManagement:ContentType')->findAll();

        foreach ($contentTypes as $contentType) {
            $fields = $contentType->getTypeFields();
            foreach ($fields as $field) {
                $fieldConfigName            = 'field.' . $field->getField()->getName();
                $contentTypeFieldConfigName = 'content_type.' . $contentType->getName() . '.' . $field->getName();
                $contentFieldTypeConfig     = $this->configManager->get($fieldConfigName);
                if ($contentFieldTypeConfig instanceof ConfigurationInterface) {
                    $contentFieldTypeFieldConfig = clone $contentFieldTypeConfig;
                    $this->configManager->set($contentTypeFieldConfigName, $contentFieldTypeFieldConfig);
                }
            }
        }
    }


}
