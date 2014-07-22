<?php
namespace Nefarian\CmsBundle\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Proxy\ProxyFactory;
use Doctrine\ORM\Tools\SchemaTool;
use Nefarian\CmsBundle\Content\Field\ContentFieldManager;
use Nefarian\CmsBundle\Plugin\ContentManagement\Model\FieldEntityInterface;

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
        $this->fieldManager   = $fieldManager;
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
        $classMetadata   = $eventArgs->getClassMetadata();
        $reflectionClass = $classMetadata->getReflectionClass();
        $className       = $reflectionClass->getName();
        $em              = $eventArgs->getEntityManager();

        if($className !== 'Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentField')
        {
            return;
        }

        // map all the fields into content type
        foreach($this->fieldManager->getFields() as $field)
        {
            //$property = $reflectionClass->getProperty('_fields');
            //$name = substr($field->getEntityClass(), strrpos($field->getEntityClass(), '\\') + 1);

            $classMetadata->setDiscriminatorMap(array(
                $field->getName() => $field->getEntityClass(),
            ));
        }
    }

    /**
     * @param LifecycleEventArgs $event
     */
    public function postUpdate(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if($entity instanceof FieldEntityInterface)
        {
            die("here");
            $em        = $event->getEntityManager();
            $fieldName = $entity->getContentField()->getName();
            $field     = $this->fieldManager->getField($fieldName);

            /** @var ClassMetadataInfo $metadata */
            var_dump($field->getEntityClass());
            $metadata = $em->getClassMetadata($field->getEntityClass());
            $name     = $metadata->getTableName() . '___' . $entity->getName();
            $metadata->setPrimaryTable(array('name' => $name));
            $metadata->setIdentifier(array(
                'id'
            ));

            $schemaTool = new SchemaTool($em);
            //$schemaTool->createSchema(array($metadata));
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
