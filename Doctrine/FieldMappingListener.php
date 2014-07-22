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

    protected $proxyDir;

    protected $proxyNamespace;

    protected $autoGenerate;

    /**
     * @param ContentFieldManager $fieldManager
     * @param string              $proxyDir
     * @param string              $proxyNamespace
     * @param string              $autoGenerate
     */
    function __construct(ContentFieldManager $fieldManager, $proxyDir, $proxyNamespace, $autoGenerate)
    {
        $this->fieldManager   = $fieldManager;
        $this->proxyDir       = $proxyDir;
        $this->proxyNamespace = $proxyNamespace;
        $this->autoGenerate   = $autoGenerate;
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
        /*
        $entity        = $eventArgs->getEmptyInstance();
        $classMetadata = $eventArgs->getClassMetadata();
        $className     = $classMetadata->getReflectionClass()->getName();
        $em            = $eventArgs->getEntityManager();

        var_dump($className);

        foreach($this->fieldManager->getFields() as $field)
        {
            if($className == $field->getEntityClass())
            {
                $proxyFactory = new ProxyFactory($eventArgs->getEntityManager(), $this->proxyDir, $this->proxyNamespace, $this->autoGenerate);

                $metadata = $em->getClassMetadata($field->getEntityClass());
                $name     = $metadata->getTableName() . '___' . $field->getName();
                $metadata->setPrimaryTable(array('name' => $name));

                var_dump($proxyFactory->generateProxyClasses(array($classMetadata)));
            }
        }
                /** @var ClassMetadataInfo $classMetadata * /
                $i  = 0;
                foreach($this->fieldManager->getFields() as $field)
                {
                    $metadata = $em->getClassMetadata($field->getEntityClass());
                    $name     = $metadata->getTableName() . '___' . $field->getName();
                    $metadata->setPrimaryTable(array('name' => $name));

                    //$schemaTool = new SchemaTool($em);
                    //$schemaTool->createSchema(array($metadata));

                    var_dump($proxyFactory->generateProxyClasses(array($classMetadata)));

                    ++$i;
                }
        */
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
