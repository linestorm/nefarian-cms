<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Controller;

use Nefarian\CmsBundle\Entity\ContentType;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\ContentTypeForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ContentTypeController extends Controller
{
    /**
     * @return Response
     */
    public function indexAction()
    {
        $em           = $this->getDoctrine()->getManager();
        $contentTypes = $em->getRepository('PluginContentManagement:ContentType')->findAll();

        return $this->render('@plugin_content_management/ContentType/index.html.twig', array(
            'contentTypes' => $contentTypes,
        ));
    }

    /**
     * Create a form for a new content type
     *
     * @return Response
     */
    public function newAction()
    {
        $newContentType = new ContentType();

        $form = $this->createForm(new ContentTypeForm(), $newContentType, array(
            'attr'   => array(
                'class' => 'api-save'
            ),
            'method' => 'POST',
            'action' => $this->generateUrl('nefarian_api_content_management_post_type'),
        ));

        return $this->render('@plugin_content_management/ContentType/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction($id)
    {
        $em          = $this->getDoctrine()->getManager();
        $contentType = $em->getRepository('PluginContentManagement:ContentType')->find($id);

        $form = $this->createForm(new ContentTypeForm(), $contentType, array(
            'attr'   => array(
                'class' => 'api-save'
            ),
            'method' => 'PUT',
            'action' => $this->generateUrl('nefarian_api_content_management_put_type', array('id' => $contentType->getId())),
        ));

        return $this->render('@plugin_content_management/ContentType/edit-tab-main.html.twig', array(
            'contentType' => $contentType,
            'form'        => $form->createView(),
        ));
    }

    public function editFieldsAction($id)
    {
        $em          = $this->getDoctrine()->getManager();
        $contentType = $em->getRepository('PluginContentManagement:ContentType')->find($id);

        $form = $this->createForm(new ContentTypeForm(), $contentType, array(
            'attr'   => array(
                'class' => 'api-save'
            ),
            'method' => 'PUT',
            'action' => $this->generateUrl('nefarian_api_content_management_put_type', array('id' => $contentType->getId())),
        ));

        return $this->render('@plugin_content_management/ContentType/edit-tab-main.html.twig', array(
            'contentType' => $contentType,
            'form'        => $form->createView(),
        ));
    }
} 
