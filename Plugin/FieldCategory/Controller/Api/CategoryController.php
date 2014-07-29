<?php

namespace Nefarian\CmsBundle\Plugin\FieldCategory\Controller\Api;

use Nefarian\CmsBundle\Controller\AbstractApiController;
use Nefarian\CmsBundle\Plugin\FieldCategory\Form\NodeCategoryForm;
use Symfony\Component\Form\AbstractType;

/**
 * Class CategoryController
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Controller\Api
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class CategoryController extends AbstractApiController
{
    /**
     * Get the form type
     *
     * @return AbstractType
     */
    function getForm()
    {
        return new NodeCategoryForm();
    }

    /**
     * Get the entity name
     *
     * @return string
     */
    function getEntityClass()
    {
        return 'Nefarian\CmsBundle\Plugin\FieldCategory\Entity\NodeCategory';
    }

    /**
     * @inheritdoc
     */
    function getUrl($method, $entity = null)
    {
        switch($method)
        {
            case self::METHOD_POST:
                return $this->generateUrl('nefarian_api_field_category_post_category');
                break;

            case self::METHOD_PUT:
                return $this->generateUrl('nefarian_api_field_category_put_category', array( 'id' => $entity->getId() ));
                break;

            case self::METHOD_DELETE:
                return $this->generateUrl('nefarian_api_field_category_delete_category', array( 'id' => $entity->getId() ));
                break;

            case self::METHOD_GET:
                return $this->generateUrl('nefarian_plugin_field_category_category_edit', array( 'id' => $entity->getId() ));
                break;
        }

        return '';
    }

    /**
     * @inheritdoc
     */
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
