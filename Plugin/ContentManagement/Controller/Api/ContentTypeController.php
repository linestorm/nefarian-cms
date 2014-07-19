<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Controller\Api;

use FOS\RestBundle\Routing\ClassResourceInterface;
use Nefarian\CmsBundle\Controller\AbstractApiController;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\ContentTypeForm;
use Symfony\Component\Form\Form;
use FOS\RestBundle\Controller\Annotations as FOSRest;

/**
 * Class ContentTypeController
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Controller\Api
 *
 * @FOSRest\RouteResource("Type")
 */
class ContentTypeController extends AbstractApiController implements ClassResourceInterface
{
    /**
     * @return Form
     */
    function getForm()
    {
        return new ContentTypeForm();
    }

    /**
     * @return string
     */
    function getEntityClass()
    {
        return 'Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType';
    }

    /**
     * @inheritdoc
     */
    function getUrl($method, $entity = null)
    {
        switch($method)
        {
            case self::METHOD_POST:
                return $this->generateUrl('nefarian_api_content_management_post_type');
                break;

            case self::METHOD_PUT:
                return $this->generateUrl('nefarian_api_content_management_put_type', array( 'id' => $entity->getId() ));
                break;

            case self::METHOD_DELETE:
                return $this->generateUrl('nefarian_api_content_management_delete_type', array( 'id' => $entity->getId() ));
                break;

            case self::METHOD_GET:
                return $this->generateUrl('nefarian_plugin_content_management_edit', array( 'id' => $entity->getId() ));
                break;
        }

        return '';
    }


} 
