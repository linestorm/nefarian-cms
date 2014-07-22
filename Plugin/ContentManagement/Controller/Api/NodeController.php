<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Controller\Api;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Nefarian\CmsBundle\Controller\ApiControllerInterface;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\NodeForm;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ContentTypeController
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Controller\Api
 *
 * @FOSRest\RouteResource("Node")
 */
class NodeController extends Controller implements ClassResourceInterface, ApiControllerInterface
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
     * @return Form
     */
    function getForm()
    {
        return new NodeForm($this->get('nefarian_core.content_field_manager'));
    }

    /**
     * @return string
     */
    function getEntityClass()
    {
        return 'Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Node';
    }

    /**
     * @inheritdoc
     */
    function getUrl($method, $entity = null)
    {
        switch($method)
        {
            case self::METHOD_POST:
                return $this->generateUrl('nefarian_api_content_management_post_type_node');
                break;

            case self::METHOD_PUT:
                return $this->generateUrl('nefarian_api_content_management_put_type_node', array('id' => $entity->getId()));
                break;

            case self::METHOD_DELETE:
                return $this->generateUrl('nefarian_api_content_management_delete_node', array('id' => $entity->getId()));
                break;

            case self::METHOD_GET:
                return $this->generateUrl('nefarian_plugin_content_management_node_edit', array('id' => $entity->getId()));
                break;
        }

        return '';
    }

    /**
     * @param Request     $request
     * @param ContentType $contentType
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function postAction(Request $request, ContentType $contentType)
    {
        if(!$contentType instanceof ContentType)
        {
            throw $this->createNotFoundException('Content Type Not Found');
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $payload = json_decode($request->getContent(), true);

        $class     = $this->getEntityClass();
        $newEntity = new $class();
        $formType  = new NodeForm($this->get('nefarian_core.content_field_manager'), $contentType);
        $form      = $this->createForm($formType, $newEntity);
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


} 
