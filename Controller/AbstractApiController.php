<?php

namespace Nefarian\CmsBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @TODO    : Permissioning
 *
 * Class AbstractApiController
 *
 * @package Nefarian\CmsBundle\Controller
 */
abstract class AbstractApiController extends Controller implements ClassResourceInterface, ApiControllerInterface
{

    /**
     * Configure the query builder
     *
     * @param QueryBuilder $qb
     *
     * @return mixed
     */
    function setupQueryBuilder(QueryBuilder $qb)
    {
    }

    /**
     * Get the template for the form
     *
     * @param $method
     *
     * @return string
     */
    function getFormTemplate($method)
    {
        return '@theme/Api/form.html.twig';
    }


    /**
     * [GET] Get all entities
     *
     * @return Response
     */
    public function cgetAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository($this->getEntityClass())->createQueryBuilder('e');
        $this->setupQueryBuilder($qb);

        $entities = $qb->getQuery()->getArrayResult();

        $view = View::create($entities);

        $view->setFormat('json');

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * [GET] Get a specific entity
     *
     * @param $id
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function getAction($id)
    {
        /** @var EntityManager $em */
        $class = $this->getEntityClass();
        $em    = $this->getDoctrine()->getManager();

        try
        {
            $qb = $em->getRepository($class)
                ->createQueryBuilder('e');
            $this->setupQueryBuilder($qb);

            $entity = $qb->andWhere('e.id = ?1')->setParameter(1, $id)
                ->getQuery()->getSingleResult(Query::HYDRATE_ARRAY);

            $view = View::create($entity);

            $view->setFormat('json');

            return $this->get('fos_rest.view_handler')->handle($view);
        }
        catch(NoResultException $e)
        {
            throw $this->createNotFoundException('Entity Not Found', $e);
        }
    }

    /**
     * [GET] Get a form for a new entity
     *
     * @return Response
     */
    public function newAction()
    {
        $class  = $this->getEntityClass();
        $entity = new $class();
        $form   = $this->createForm($this->getForm(), $entity, array(
            'method' => 'POST',
            'action' => $this->getUrl(self::METHOD_POST),
        ));

        $html = $this->render($this->getFormTemplate(self::METHOD_NEW), array(
            'form' => $form->createView()
        ));

        $rView = View::create(array(
            'form' => $html,
        ));

        return $this->get('fos_rest.view_handler')->handle($rView);
    }

    /**
     * [GET] Get a form for an existing entity
     *
     * @param $id
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function editAction($id)
    {
        /** @var EntityManager $em */
        $class = $this->getEntityClass();
        $em    = $this->getDoctrine()->getManager();

        try
        {
            $qb = $em->getRepository($class)
                ->createQueryBuilder('e');
            $this->setupQueryBuilder($qb);

            $entity = $qb->andWhere('e.id = ?1')->setParameter(1, $id)
                ->getQuery()->getSingleResult();
        }
        catch(NoResultException $e)
        {
            throw $this->createNotFoundException('Entity Not Found', $e);
        }

        $form = $this->createForm($this->getForm(), $entity, array(
            'action' => $this->getUrl(self::METHOD_PUT, $entity),
            'method' => 'PUT',
        ));

        $html = $this->render($this->getFormTemplate(self::METHOD_EDIT), array(
            'form' => $form->createView()
        ));

        $rView = View::create(array(
            'form' => $html,
        ));

        return $this->get('fos_rest.view_handler')->handle($rView);
    }

    /**
     * [POST] Save a form
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $payload = json_decode($request->getContent(), true);

        $class     = $this->getEntityClass();
        $newEntity = new $class();
        $formType  = $this->getForm();
        $form      = $this->createForm($formType, $newEntity);
        $form->submit($payload[$formType->getName()]);

        if($form->isValid())
        {
            $entity = $form->getData();

            $this->preCreate($entity);

            $em->persist($entity);
            $em->flush();

            $this->postCreate($entity);

            $view = View::create($entity, 201, array(
                'location' => $this->getUrl(self::METHOD_GET, $entity)
            ));
        }
        else
        {
            $view = View::create($form);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * [PUT] Save a form
     *
     * @param Request $request
     * @param int     $id
     *
     * @throws NotFoundHttpException
     * @return Response
     */
    public function putAction(Request $request, $id)
    {
        /** @var EntityManager $em */
        $class  = $this->getEntityClass();
        $em     = $this->getDoctrine()->getManager();
        $entity = $em->getRepository($class)->find($id);

        if(!$entity instanceof $class)
        {
            throw $this->createNotFoundException('Entity Not Found');
        }

        $payload = json_decode($request->getContent(), true);

        $formType = $this->getForm();
        $form     = $this->createForm($formType, $entity);
        $form->submit($payload[$formType->getName()]);

        if($form->isValid())
        {
            $entity = $form->getData();

            $this->preUpdate($entity);

            $em->persist($entity);
            $em->flush();

            $this->postUpdate($entity);

            $view = View::create($entity, 200);
        }
        else
        {
            $view = View::create($form);
        }

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     * [DELETE] Delete a node
     *
     * @param $id
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function deleteAction($id)
    {
        /** @var EntityManager $em */
        $class  = $this->getEntityClass();
        $em     = $this->getDoctrine()->getManager();
        $entity = $em->getRepository($class)->find($id);

        if(!$entity instanceof $class)
        {
            throw $this->createNotFoundException('Entity Not Found');
        }

        $this->preDelete($entity);

        $em->remove($entity);
        $em->flush();

        $this->postDelete();

        $view = View::create(null, 204);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    protected function preGet()
    {
    }

    protected function postGet()
    {
    }

    protected function preNew()
    {
    }

    protected function postNew()
    {
    }

    protected function preEdit()
    {
    }

    protected function postEdit()
    {
    }

    protected function preCreate($entity)
    {
    }

    protected function postCreate($entity)
    {
    }

    protected function preUpdate($entity)
    {
    }

    protected function postUpdate($entity)
    {
    }

    protected function preDelete($entity)
    {
    }

    protected function postDelete()
    {
    }
}
