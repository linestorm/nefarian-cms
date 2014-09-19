<?php

namespace Nefarian\CmsBundle\Plugin\Media\Controller\Api;

use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Nefarian\CmsBundle\Controller\AbstractApiController;
use Nefarian\CmsBundle\Plugin\Media\Form\MediaFormType;
use Nefarian\CmsBundle\Plugin\Media\Model\MediaCategory;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Media Category Contriller
 *
 * Class CategoryController
 *
 * @package Nefarian\CmsBundle\Plugin\Media\Controller\Api
 */
class CategoryController extends AbstractApiController implements ClassResourceInterface
{
    /**
     * @return Form
     */
    function getForm()
    {
        $mediaManager = $this->get('nefarian.plugin.media.manager');
        return new MediaFormType($mediaManager);
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
                return $this->generateUrl('nefarian_api_content_management_put_type', array('id' => $entity->getId()));
                break;

            case self::METHOD_DELETE:
                return $this->generateUrl('nefarian_api_content_management_delete_type', array('id' => $entity->getId()));
                break;

            case self::METHOD_GET:
                return $this->generateUrl('nefarian_plugin_content_management_content_type_edit', array('id' => $entity->getId()));
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
