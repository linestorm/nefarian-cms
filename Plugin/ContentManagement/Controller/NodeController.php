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
        $em          = $this->getDoctrine()->getManager();
        /** @var ContentType $contentType */
        $contentType = $em->getRepository('PluginContentManagement:ContentType')->find($id);

        if(!$contentType instanceof ContentType)
        {
            throw $this->createNotFoundException('Content Type Not Found');
        }

        $fieldManager = $this->get('nefarian_core.content_field_manager');
        $newContentType = new Node();

        $form = $this->createForm(new NodeForm($contentType, $fieldManager), $newContentType, array(
            'attr'   => array(
                'class' => 'api-save'
            ),
            'method' => 'POST',
            'action' => $this->generateUrl('nefarian_api_content_management_post_type'),
        ));

        $fieldForms = array();
        $fieldViews = array();
        // get the content type fields
        foreach($contentType->getTypeFields() as $fieldType)
        {
            $field = $fieldManager->getField($fieldType->getContentField()->getName());
            $entityClass = $field->getEntityClass();
            $formClass = $field->getForm();

            $fieldForms[] = $fieldForm = $this->createForm(new $formClass($contentType), new $entityClass());
            $fieldViews = $fieldForm->createView();
        }

        return $this->render('@plugin_content_management/Node/new.html.twig', array(
            'contentType' => $contentType,
            'form'        => $form->createView(),
            'fieldForms'  => $fieldViews,
        ));
    }


} 
