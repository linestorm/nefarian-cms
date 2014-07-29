<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Controller\Api;

use Nefarian\CmsBundle\Controller\AbstractApiController;
use Nefarian\CmsBundle\Plugin\FieldTag\Form\NodeTagForm;
use Symfony\Component\Form\AbstractType;

/**
 * Class TagController
 *
 * @package Nefarian\CmsBundle\Plugin\FieldTag\Controller\Api
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagController extends AbstractApiController
{
    /**
     * Get the form type
     *
     * @return AbstractType
     */
    function getForm()
    {
        return new NodeTagForm();
    }

    /**
     * Get the entity name
     *
     * @return string
     */
    function getEntityClass()
    {
        return 'Nefarian\CmsBundle\Plugin\FieldTag\Entity\NodeTag';
    }

    /**
     * @inheritdoc
     */
    function getUrl($method, $entity = null)
    {
        switch($method)
        {
            case self::METHOD_POST:
                return $this->generateUrl('nefarian_api_field_tag_post_tag');
                break;

            case self::METHOD_PUT:
                return $this->generateUrl('nefarian_api_field_tag_put_tag', array( 'id' => $entity->getId() ));
                break;

            case self::METHOD_DELETE:
                return $this->generateUrl('nefarian_api_field_tag_delete_tag', array( 'id' => $entity->getId() ));
                break;

            case self::METHOD_GET:
                return $this->generateUrl('nefarian_plugin_field_tag_tag_edit', array( 'id' => $entity->getId() ));
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
