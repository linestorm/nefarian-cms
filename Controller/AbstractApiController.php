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
 * @TODO    : Form URL Targets
 * @TODO    : putAction
 * @TODO    : deleteAction
 *
 * Class AbstractApiController
 *
 * @package Nefarian\CmsBundle\Controller
 */
abstract class AbstractApiController extends Controller implements ClassResourceInterface, ApiControllerInterface
{
    const METHOD_GET    = 0;
    const METHOD_NEW    = 1;
    const METHOD_EDIT   = 2;
    const METHOD_POST   = 3;
    const METHOD_PUT    = 4;
    const METHOD_DELETE = 5;

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
     * @param Request $request
     *
     * @return Response
     */
    public function newAction(Request $request)
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

        $formType = $this->getForm();
        $form     = $this->createForm($formType);
        $form->submit($payload[$formType->getName()]);

        if($form->isValid())
        {
            $entity = $form->getData();

            $em->persist($entity);
            $em->flush();

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

    public function putAction(Request $request, $id)
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

        $payload = json_decode($request->getContent(), true);

        $formType = $this->getForm();
        $form     = $this->createForm($formType, $entity);
        $form->submit($payload[$formType->getName()]);

        if($form->isValid())
        {
            $entity = $form->getData();

            $em->persist($entity);
            $em->flush();

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

    public function deleteAction(Request $request, $id)
    {
    }
}
