<?php

namespace Nefarian\CmsBundle\Plugin\ContentManagement\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
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
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        try
        {
            $dql = "
                SELECT
                  ct, tf
                FROM
                  PluginContentManagement:ContentType ct
                LEFT JOIN
                  ct.typeFields tf
                WHERE
                  ct.id = ?1
            ";
            $contentType = $em->createQuery($dql)->setParameter(1, $id)->getSingleResult();
        }
        catch(NoResultException $e)
        {
            throw $this->createNotFoundException('Content Type Not Found', $e);
        }

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

        if(!$contentType instanceof ContentType)
        {
            throw $this->createNotFoundException('Content Type Not Found');
        }

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
