<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Controller;

use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Node;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\NodeForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class NodeController
 *
 * @package Nefarian\CmsBundle\Plugin\ContentManagement\Controller
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class NodeController extends Controller
{
    public function viewAction(Node $node)
    {

        return $this->render('@plugin_content_management/Node/view.html.twig', array(
            'node' => $node,
        ));
    }
} 
