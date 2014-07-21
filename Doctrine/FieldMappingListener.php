<?php

namespace Nefarian\CmsBundle\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Tools\SchemaTool;
use Nefarian\CmsBundle\Content\Field\ContentFieldManager;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentTypeField;

class FieldMappingListener implements EventSubscriber
{
    /**
     * @var ContentFieldManager
     */
    protected $fieldManager;

    /**
     * @param ContentFieldManager $fieldManager
     */
    function __construct(ContentFieldManager $fieldManager)
    {
        $this->fieldManager = $fieldManager;
    }

    /**
     * {@inheritDoc}
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::loadClassMetadata,
            Events::preUpdate,
            Events::postUpdate,
        );
    }

    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        return;

        $classMetadata = $eventArgs->getClassMetadata();
        $className     = $classMetadata->getReflectionClass()->getName();

        if($className != "Nefarian\\CmsBundle\\Plugin\\ContentManagement\\Entity\\ContentField")
        {
            return;
        }

        /** @var ClassMetadataInfo $classMetadata */
        $em = $eventArgs->getEntityManager();
        $i  = 0;
        foreach($this->fieldManager->getFields() as $field)
        {
            $metadata = $em->getClassMetadata($field->getEntityClass());
            $name     = $metadata->getTableName() . '_' . $i;
            $metadata->setPrimaryTable(array('name' => $name));

            $schemaTool = new SchemaTool($em);
            $schemaTool->createSchema(array($metadata));

            ++$i;
        }

        return;
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function postUpdate(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if($entity instanceof ContentTypeField)
        {
            $em        = $event->getEntityManager();
            $fieldName = $entity->getContentField()->getName();
            $field     = $this->fieldManager->getField($fieldName);
            var_dump($field->getEntityClass());
            $metadata  = $em->getClassMetadata($field->getEntityClass());
            $name      = $metadata->getTableName() . '___' . $entity->getName();
            $metadata->setPrimaryTable(array('name' => $name));

            $schemaTool = new SchemaTool($em);
            $schemaTool->createSchema(array($metadata));
            $schemaTool->updateSchema(array($metadata), true);

        }
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function preUpdate(LifecycleEventArgs $event)
    {

    }

}
