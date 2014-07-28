<?php

namespace Nefarian\CmsBundle\Plugin\FieldTag\Controller;

use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\ContentType;
use Nefarian\CmsBundle\Plugin\ContentManagement\Entity\Node;
use Nefarian\CmsBundle\Plugin\ContentManagement\Form\NodeForm;
use Nefarian\CmsBundle\Plugin\FieldTag\Entity\NodeTag;
use Nefarian\CmsBundle\Plugin\FieldTag\Form\NodeTagForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class TagController
 *
 * @package Nefarian\CmsBundle\Plugin\FieldTag\Controller
 * @author  Andy Thorne <contrabandvr@gmail.com>
 */
class TagController extends Controller
{
    public function indexAction()
    {
        $em    = $this->getDoctrine()->getManager();
        $tags = $em->getRepository('PluginFieldTag:NodeTag')->findAll();

        return $this->render('@plugin_field_tag/Tag/index.html.twig', array(
            'tags' => $tags,
        ));
    }


    /**
     * @throws NotFoundHttpException
     *
     * @return Response
     */
    public function newAction()
    {
        $tag = new NodeTag();

        $form = $this->createForm(new NodeTagForm(), $tag, array(
            'attr'   => array(
                'class' => 'api-save'
            ),
            'method' => 'POST',
            'action' => $this->generateUrl('nefarian_api_field_tag_post_tag'),
        ));

        return $this->render('@plugin_field_tag/Tag/new.html.twig', array(
            'form'        => $form->createView(),
        ));
    }

    public function editAction(NodeTag $nodeTag)
    {
        $form = $this->createForm(new NodeTagForm(), $nodeTag, array(
            'attr'   => array(
                'class' => 'api-save'
            ),
            'method' => 'PUT',
            'action' => $this->generateUrl('nefarian_api_field_tag_put_tag', array(
                'id' => $nodeTag->getId()
            )),
        ));

        return $this->render('@plugin_field_tag/Tag/edit.html.twig', array(
            'tag' => $nodeTag,
            'form' => $form->createView(),
        ));
    }


} 
