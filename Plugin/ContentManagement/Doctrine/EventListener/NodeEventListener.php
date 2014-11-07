<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Doctrine\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Node;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Class NodeListener
 *
 * @package Nefarian\CmsBundle\Plugin\ConentManagement\Doctrine\EventListener
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeEventListener implements EventSubscriber
{
    /**
     * @var SecurityContext
     */
    protected $securityContext;

    function __construct(SecurityContext $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @inheritdoc
     */
    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate',
        );
    }

    /**
     * On pre-persist, set the createdBy and CreatedOn fields
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if($entity instanceof Node)
        {
            $user = $this->securityContext->getToken()->getUser();
            if(!$entity->getCreatedBy())
            {
                $entity->setCreatedBy($user);
            }

            if(!$entity->getCreatedOn())
            {
                $entity->setCreatedOn(new \DateTime());
            }
        }

        if($entity instanceof ContentType)
        {
            $em = $args->getEntityManager();

            foreach ($entity->getTypeFields() as $field) {
                $fieldConfigName = 'content_type.' . $entity->getName() . '.' . $field->getName();
                $this->configManager->duplicate($field->getField()->getName() . '.settings', $fieldConfigName);
            }
        }

    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if($entity instanceof Node)
        {
            $user = $this->securityContext->getToken()->getUser();
            $entity->setEditedBy($user);
            $entity->setEditedOn(new \DateTime());
        }
    }
} 
