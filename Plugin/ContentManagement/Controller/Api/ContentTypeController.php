<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Controller\Api;

use FOS\RestBundle\Routing\ClassResourceInterface;
use Nefarian\CmsBundle\Controller\AbstractApiController;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\ContentTypeForm;
use Symfony\Component\Form\Form;
use FOS\RestBundle\Controller\Annotations\RouteResource;

/**
 * Class ContentTypeController
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Controller\Api
 *
 * @RouteResource("content-type")
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
        return '\Nefarian\CmsBundle\Entity\ContentType';
    }

} 
