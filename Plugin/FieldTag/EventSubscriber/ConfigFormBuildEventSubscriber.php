<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\EventSubscriber;

use Doctrine\ORM\EntityRepository;
use Nefarian\CmsBundle\Configuration\ConfigManager;
use Nefarian\CmsBundle\Configuration\Event\ConfigFormBuildEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Created by Andy Thorne
 *
 * @author Andy Thorne <contrabandvr@gmail.com>
 */
class ConfigFormBuildEventSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            ConfigManager::CONFIG_FORM_BUILD => array(
                array('onConfigFormBuild', 10),
            )
        );
    }

    public function onConfigFormBuild(ConfigFormBuildEvent $event)
    {
        return;
        $form = $event->getForm();
        if ($form->getName() == 'nefarian_config_settings') {
            $configuration = $form->getConfiguration();
            foreach ($configuration->getAllSchemas() as $name => $schema) {
                $schema->type    = 'entity';
                $schema->options = array(
                    'class' => 'Nefarian\CmsBundle\Plugin\FieldTag\Entity\NodeTag',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('t')
                            ->select('t')
                            ->where('size(t.childTags) = 0')
                            ->orderBy('t.name', 'ASC');
                    },
                    'property' => 'name',
                );
            }
        }
    }

} 
