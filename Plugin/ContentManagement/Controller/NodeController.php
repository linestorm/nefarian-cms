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
    /**
     * @return Response
     */
    public function newSelectAction()
    {
        $em           = $this->getDoctrine()->getManager();
        $contentTypes = $em->getRepository('PluginContentManagement:ContentType')->findAll();

        return $this->render('@plugin_content_management/Node/new-select.html.twig', array(
            'contentTypes' => $contentTypes,
        ));
    }


    /**
     * @param $id
     *
     * @throws NotFoundHttpException
     * @return Response
     */
    public function newAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var ContentType $contentType */
        $contentType = $em->getRepository('PluginContentManagement:ContentType')->find($id);

        if(!$contentType instanceof ContentType)
        {
            throw $this->createNotFoundException('Content Type Not Found');
        }

        $fieldManager = $this->get('nefarian_core.content_field_manager');
        $node         = new Node();

        $form = $this->createForm(new NodeForm($fieldManager, $contentType), $node, array(
            'attr'   => array(
                'class' => 'api-save'
            ),
            'method' => 'POST',
            'action' => $this->generateUrl('nefarian_api_content_management_post_type_node', array(
                'contentType' => $contentType->getId()
            )),
        ));

        return $this->render('@plugin_content_management/Node/new.html.twig', array(
            'contentType' => $contentType,
            'form'        => $form->createView(),
        ));
    }

} 
