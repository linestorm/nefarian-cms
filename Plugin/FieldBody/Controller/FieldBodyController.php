<?php

namespace Nefarian\CmsBundle\Plugin\FieldBody\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class FieldBodyController
 *
 * @package Nefarian\CmsBundle\Plugin\FieldBody\Controller
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class FieldBodyController extends Controller
{
    public function indexAction()
    {
        $em           = $this->getDoctrine()->getManager();
        $contentTypes = $em->getRepository('PluginFieldBody:FieldBody')->findAll();

        return $this->render('@plugin_field_body/Field/index.html.twig', array(
            'contentTypes' => $contentTypes,
        ));
    }
} 
