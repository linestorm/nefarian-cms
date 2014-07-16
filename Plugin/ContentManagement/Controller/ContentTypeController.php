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
        $em = $this->getDoctrine()->getManager();
        $contentTypes = $em->getRepository('NefarianCmsBundle:ContentType')->findAll();

        return $this->render('@plugin_content_management/index.html.twig', array(
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
            'action' => $this->generateUrl()
        ));

        return $this->render('@plugin_content_management/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
} 
