<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Doctrine\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Nefarian\CmsBundle\Entity\Route;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Node;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Route as SymfonyRoute;

/**
 * Class NodeListener
 *
 * @package Nefarian\CmsBundle\Plugin\ConentManagement\Doctrine\EventListener
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeEventListener implements EventSubscriber
{
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
            Events::prePersist,
            Events::preUpdate
        );
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $em  = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach ($uow->getScheduledEntityDeletions() as $entity) {
            if ($entity instanceof Node) {

                $routeRepo = $em->getRepository('NefarianCmsBundle:Route');
                $route     = $routeRepo->findOneBy(array(
                    'path' => $entity->getPath()
                ));

                $symfonyRoute = $this->createNewNodeDeletedRoute($entity->getPath());
                if (!$route instanceof Route) {
                    $path = $entity->getPath();
                    // create the new route
                    $route = $this->createNewNodeRouteEntity($path, $symfonyRoute);
                } else {
                    $route->setRoute($symfonyRoute);
                }

                $em->persist($route);
                $uow->computeChangeSets();
            }
        }

        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            if ($entity instanceof Node) {
                $changeSet = $uow->getEntityChangeSet($entity);
var_dump($changeSet);die;
                $routeRepo = $em->getRepository('NefarianCmsBundle:Route');
                $route     = $routeRepo->findOneBy(array(
                    'path' => $entity->getPath()
                ));

                if (!$route instanceof Route) {
                    $path = $entity->getPath();
                    // create the new route
                    $symfonyRoute = $this->createNewNodeRoute($entity);
                    $route = $this->createNewNodeRouteEntity($path, $symfonyRoute);
                    $em->persist($route);

                    $uow->computeChangeSets();
                }

                if (isset($changeSet['deletedOn'])) {
                    if ($changeSet['deletedOn'] instanceof \DateTime) {
                        // delete
                        $symfonyRoute = $this->createNewNodeDeletedRoute($entity->getPath());
                        $route->setRoute($symfonyRoute);
                    } else {
                        // un-delete
                        $symfonyRoute = $this->createNewNodeRoute($entity);
                        $newRoute = $this->createNewNodeRouteEntity($entity->getPath(), $symfonyRoute);
                    }
                    $em->persist($newRoute);
                } elseif ($changeSet['path']) {
                    list($oldPath, $newPath) = $changeSet['path'];

                    // create the new route entity
                    $symfonyRoute = $this->createNewNodeRoute($entity);
                    $newRoute = $this->createNewNodeRouteEntity($newPath, $symfonyRoute);
                    $em->persist($newRoute);

                    // set any old route to redirtect to the new route
                    $oldRoute = $routeRepo->findOneBy(array(
                        'path' => $oldPath
                    ));
                    if ($oldRoute) {
                        $oldSymfonyRoute = $oldRoute->getRoute();
                        $newSymfonyRoute = $this->createNewNodeRedirectRoute($oldSymfonyRoute->getPath(), $symfonyRoute->getPath());
                        $oldRoute->setRoute($newSymfonyRoute);
                        $em->persist($oldRoute);
                    }

                    $uow->computeChangeSets();
                }
            }
        }
    }


    /**
     * On pre-persist, set the createdBy and CreatedOn fields
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if ($entity instanceof Node) {
            if (!$entity->getCreatedBy()) {
                $user = $this->container->get('security.context')->getToken()->getUser();
                $entity->setCreatedBy($user);
            }

            if (!$entity->getCreatedOn()) {
                $entity->setCreatedOn(new \DateTime());
            }
        }
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        return;
        $entity = $args->getEntity();

        if ($entity instanceof Node) {
            $user = $this->container->get('security.context')->getToken()->getUser();
            $entity->setEditedBy($user);
            $entity->setEditedOn(new \DateTime());
        }
    }

    protected function createNewNodeRoute(Node $node)
    {
        return new SymfonyRoute($node->getPath(), array(
            '_controller' => '\Nefarian\CmsBundle\Plugin\ContentManagement\Controller\NodeController::viewAction',
            'node' => $node->getId(),
        ));
    }

    protected function createNewNodeRedirectRoute($oldPath, $newPath)
    {
        $newSymfonyRoute = new SymfonyRoute($oldPath);
        $newSymfonyRoute->setDefaults(array(
            '_controller' => 'FrameworkBundle:Redirect:urlRedirect',
            'path' => $newPath,
            'permanent' => true,
        ));

        return $newSymfonyRoute;
    }

    protected function createNewNodeDeletedRoute($path)
    {
        return $this->createNewNodeRedirectRoute($path, '');
    }

    protected function createNewNodeRouteEntity($path, SymfonyRoute $route)
    {
        $newPathName  = str_replace('/', '_', ltrim($path, '/'));

        $newRoute = new Route();
        $newRoute->setName('nefarian_node_' . $newPathName);
        $newRoute->setPattern($path);
        $newRoute->setPath($path);
        $newRoute->setRoute($route);

        return $newRoute;
    }

} 
