<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Controller\Api;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nefarian\CmsBundle\Controller\AbstractApiController;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
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
                return $this->generateUrl('nefarian_plugin_content_management_content_type_edit', array( 'id' => $entity->getId() ));
                break;
        }

        return '';
    }

    function hasPermission($method)
    {
        $userManager = $this->get('nefarian_core.user_manager');
        switch($method)
        {
            case self::METHOD_NEW:
            case self::METHOD_POST:
                return $userManager->hasPermission($this->getUser(), 'content.type.create');
                break;

            case self::METHOD_EDIT:
            case self::METHOD_PUT:
                return $userManager->hasPermission($this->getUser(), 'content.type.update');
                break;

            case self::METHOD_DELETE:
                return $userManager->hasPermission($this->getUser(), 'content.type.delete');
                break;

            case self::METHOD_GET:
                return $userManager->hasPermission($this->getUser(), 'content.type.get');
                break;
        }

        return false;
    }


} 
