<?php

namespace Nefarian\CmsBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\AbstractType;

// @TODO: permissioning
abstract class AbstractApiController extends Controller implements ClassResourceInterface
{
    /**
     * @return AbstractType
     */
    abstract function getForm();

    /**
     * @return string
     */
    abstract function getEntityClass();

    public function cgetAction()
    {
        /** @var EntityManager $em */
        $em       = $this->getDoctrine()->getManager();
        $entities = $em->getRepository($this->getEntityClass())->createQueryBuilder('e')->getQuery()->getArrayResult();

        $view = View::create($entities);

        $view->setFormat('json');
        $this->get('fos_rest.view_handler')->handle($view);
    }

    public function getAction($id)
    {
        /** @var EntityManager $em */
        $class  = $this->getEntityClass();
        $em     = $this->getDoctrine()->getManager();

        try
        {
            $entity = $em->getRepository($class)
                ->createQueryBuilder('e')
                ->where('e.id = ?1')->setParameter(1, $id)
                ->getQuery()->getSingleResult(Query::HYDRATE_ARRAY);

            $view = View::create($entity);

            $view->setFormat('json');
            $this->get('fos_rest.view_handler')->handle($view);
        }
        catch(NoResultException $e)
        {
            throw $this->createNotFoundException('Entity Not Found', $e);
        }
    }

    public function newAction()
    {
        $class = $this->getEntityClass();
        $entity = new $class();
        $form = $this->createForm($this->getForm(), $entity, array(
            'method' => 'POST'
        ));

        $formView = $form->createView();

        $view = View::create($formView);
        $view->setFormat('json');
        $this->get('fos_rest.view_handler')->handle($view);
    }

    public function editAction($id)
    {
    }

    public function postAction()
    {
    }

    public function putAction($id)
    {
    }

    public function deleteAction($id)
    {
    }
}
