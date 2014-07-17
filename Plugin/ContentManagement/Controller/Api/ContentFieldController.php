<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Controller\Api;

use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations\RouteResource;

/**
 * Class ContentFieldController
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Controller\Api
 *
 * @RouteResource("Field")
 */
class ContentFieldController extends Controller implements ClassResourceInterface
{
    public function cgetAction()
    {}

    public function getAction($id)
    {}

    public function newAction()
    {}

    public function editAction($id)
    {}

    public function postAction()
    {}

    public function putAction($id)
    {}

    public function deleteAction($id)
    {}
} 
